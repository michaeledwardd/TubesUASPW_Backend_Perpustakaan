<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; //Import library untuk Validasi
use App\Models\Denda;

class DendaController extends Controller
{
    //Method untuk menampilkan semua data product (READ)
    public function index()
    {
        $dendas = Denda::all(); //Mengambil semua data denda

        if (count($dendas) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $dendas
            ], 200);
        } //Return data semua denda dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data denda kosong
    }

    //Method untuk menampilkan 1 data denda (SEARCH)
    public function show($id)
    {
        $dendas = Denda::find($id); //Mencari data denda berdasarkan id

        if (!is_null($dendas)) {
            return response([
                'message' => 'Retrieve denda Success',
                'data' => $dendas
            ], 200);
        } //Return data semua denda dalam bentuk JSON

        return response([
            'message' => 'Denda Not Found',
            'data' => null
        ], 400); //Return message data denda kosong
    }

    //Method untuk menambah 1 data denda baru (CREATE)
    public function store(Request $request)
    {
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'namaPeminjam' => 'required|max:60|regex:/^[\pL\s\-]+$/u',
            'jumlahDenda' => 'required|numeric',
            'Status' => 'required|regex:/^[\pL\s\-]+$/u',
            'TanggalPembayaran' => 'required|date_format:Y-m-d'
        ]); //Membuat rule validasi input

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $denda = Denda::create($storeData);

        return response([
            'message' => 'Add Denda Success',
            'data' => $denda
        ], 200); //Return message data denda baru dalam bentuk JSON
    }

    //Method untuk menghapus 1 data product (DELETE)
    public function destroy($id)
    {
        $denda = Denda::find($id); //Mencari data product berdasarkan id

        if (is_null($denda)) {
            return response([
                'message' => 'Denda Not Found',
                'date' => null
            ], 404);
        } //Return message saat data denda tidak ditemukan

        if ($denda->delete()) {
            return response([
                'message' => 'Delete Denda Success',
                'data' => $denda
            ], 200);
        } //Return message saat berhasil menghapus data denda

        return response([
            'message' => 'Delete Denda Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data denda (UPDATE)
    public function update(Request $request, $id)
    {
        $denda = Denda::find($id); //Mencari data denda berdasarkan id

        if (is_null($denda)) {
            return response([
                'message' => 'denda Not Found',
                'data' => null
            ], 404);
        } //Return message saat data denda tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaPeminjam' => 'required|max:60|regex:/^[\pL\s\-]+$/u',
            'jumlahDenda' => 'required|numeric',
            'Status' => 'required|regex:/^[\pL\s\-]+$/u',
            'TanggalPembayaran' => 'required|date_format:Y-m-d'
        ]); //Membuat rule validasi input

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $denda->namaPeminjam = $updateData['namaPeminjam']; //Edit namaPeminjam
        $denda->jumlahDenda = $updateData['jumlahDenda']; //Edit jumlahDenda
        $denda->Status = $updateData['Status']; //Edit Status
        $denda->TanggalPembayaran = $updateData['TanggalPembayaran']; //Edit TanggalPembayaran

        if ($denda->save()) {
            return response([
                'message' => 'Update Denda Success',
                'data' => $denda
            ], 200);
        } //Return data denda yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update Denda Failed',
            'data' => null
        ], 400);
    }
}