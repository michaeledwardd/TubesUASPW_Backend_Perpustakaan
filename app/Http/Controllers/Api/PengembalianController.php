<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; //Import library untuk Validasi
use App\Models\Pengembalian;

class PengembalianController extends Controller
{
    //Method untuk menampilkan semua data product (READ)
    public function index(){
        $pengembalians = Pengembalian::all(); //Mengambil semua data Pengembalian

        if(count($pengembalians) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pengembalians
            ], 200);
        } //Return data semua Pengembalian dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data Pengembalian kosong
    }

    //Method untuk menampilkan 1 data Pengembalian (SEARCH)
    public function show($id){
        $pengembalians = Pengembalian::find($id); //Mencari data Pengembalian berdasarkan id

        if(!is_null($pengembalians)){
            return response([
                'message' => 'Retrieve Pengembalian Success',
                'data' => $pengembalians
            ], 200);
        } //Return data semua Pengembalian dalam bentuk JSON

        return response([
            'message' => 'Pengembalian Not Found',
            'data' => null
        ], 400); //Return message data Pengembalian kosong
    }

    //Method untuk menambah 1 data Pengembalian baru (CREATE)
    public function store(Request $request){
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'namaPeminjam' => 'required',
            'statusPengembalian' => 'required',
            'nomorIdentitas' => 'required',
            'judulBuku' => 'required'
        ]); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Pengembalian = Pengembalian::create($storeData);

        return response([
            'message' => 'Add Pengembalian Success',
            'data' => $Pengembalian
        ], 200); //Return message data Pengembalian baru dalam bentuk JSON
    }

    //Method untuk menghapus 1 data product (DELETE)
    public function destroy($id){
        $Pengembalian = Pengembalian::find($id); //Mencari data product berdasarkan id

        if(is_null($Pengembalian)){
            return response([
                'message' => 'Pengembalian Not Found',
                'date' => null
            ], 404);
        } //Return message saat data Pengembalian tidak ditemukan

        if($Pengembalian->delete()){
            return response([
                'message' => 'Delete Pengembalian Success',
                'data' => $Pengembalian
            ], 200);
        } //Return message saat berhasil menghapus data Pengembalian

        return response([
            'message' => 'Delete Pengembalian Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data Pengembalian (UPDATE)
    public function update(Request $request, $id){
        $Pengembalian = Pengembalian::find($id); //Mencari data Pengembalian berdasarkan id

        if(is_null($Pengembalian)){
            return response([
                'message' => 'Pengembalian Not Found',
                'data' => null
            ], 404);
        } //Return message saat data Pengembalian tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaPeminjam' => 'required',
            'statusPengembalian' => 'required',
            'nomorIdentitas' => 'required',
            'judulBuku' => 'required'
        ]); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $pengembalian->namaPeminjam = $updateData['namaPeminjam']; //Edit namaPeminjam
        $pengembalian->StatusPengembalian = $updateData['StatusPengembalian']; //Edit StatusPengembalian
        $pengembalian->nomorIdentitas = $updateData['nomorIdentitas']; //Edit nomorIdentitas
        $pengembalian->judulBuku = $updateData['judulBuku']; //Edit judulBuku

        if($Pengembalian->save()){
            return response([
                'message' => 'Update Pengembalian Success',
                'data' => $Pengembalian
            ], 200);
        } //Return data Pengembalian yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update Pengembalian Failed',
            'data' => null
        ], 400);
    }
}
