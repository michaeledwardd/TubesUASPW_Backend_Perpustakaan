<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; //Import library untuk Validasi
use App\Models\Borrow;

class BorrowController extends Controller
{
    //Method untuk menampilkan semua data product (READ)
    public function index(){
        $borrows = Borrow::all(); //Mengambil semua data Borrow

        if(count($borrows) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $borrows
            ], 200);
        } //Return data semua Borrow dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data Borrow kosong
    }

    //Method untuk menampilkan 1 data Borrow (SEARCH)
    public function show($id){
        $borrows = Borrow::find($id); //Mencari data Borrow berdasarkan id

        if(!is_null($borrows)){
            return response([
                'message' => 'Retrieve Borrow Success',
                'data' => $borrows
            ], 200);
        } //Return data semua Borrow dalam bentuk JSON

        return response([
            'message' => 'Borrow Not Found',
            'data' => null
        ], 400); //Return message data Borrow kosong
    }

    //Method untuk menambah 1 data Borrow baru (CREATE)
    public function store(Request $request){
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'namaPeminjam' => 'required|regex:/^[\pL\s\-]+$/u',
            'tanggalPeminjaman' => 'required',
            'tanggalPengembalian' => 'required',
            'nomorIdentitas' => 'required|numeric',
            'judulBuku' => 'required'
        ]); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $borrow = Borrow::create($storeData);

        return response([
            'message' => 'Add Borrow Success',
            'data' => $borrow
        ], 200); //Return message data Borrow baru dalam bentuk JSON
    }

    //Method untuk menghapus 1 data product (DELETE)
    public function destroy($id){
        $borrow = Borrow::find($id); //Mencari data product berdasarkan id

        if(is_null($borrow)){
            return response([
                'message' => 'Borrow Not Found',
                'date' => null
            ], 404);
        } //Return message saat data Borrow tidak ditemukan

        if($borrow->delete()){
            return response([
                'message' => 'Delete Borrow Success',
                'data' => $borrow
            ], 200);
        } //Return message saat berhasil menghapus data Borrow

        return response([
            'message' => 'Delete Borrow Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data Borrow (UPDATE)
    public function update(Request $request, $id){
        $borrow = Borrow::find($id); //Mencari data Borrow berdasarkan id

        if(is_null($borrow)){
            return response([
                'message' => 'Borrow Not Found',
                'data' => null
            ], 404);
        } //Return message saat data Borrow tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaPeminjam' => 'required|regex:/^[\pL\s\-]+$/u',
            'tanggalPeminjaman' => 'required',
            'tanggalPengembalian' => 'required',
            'nomorIdentitas' => 'required|numeric',
            'judulBuku' => 'required'
        ]); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $borrow->namaPeminjam = $updateData['namaPeminjam']; //Edit judulBorrow
        $borrow->tanggalPeminjaman = $updateData['tanggalPeminjaman']; //Edit isbn
        $borrow->tanggalPengembalian = $updateData['tanggalPengembalian']; //Edit tahunterbit
        $borrow->nomorIdentitas = $updateData['nomorIdentitas']; //Edit pengarang
        $borrow->judulBuku = $updateData['judulBuku']; //Edit pengarang

        if($borrow->save()){
            return response([
                'message' => 'Update Borrow Success',
                'data' => $borrow
            ], 200);
        } //Return data Borrow yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update Borrow Failed',
            'data' => null
        ], 400);
    }
}
