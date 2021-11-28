<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; //Import library untuk Validasi
use App\Models\User;
class UserController extends Controller
{
    //Method untuk menampilkan semua data product (READ)
    public function index(){
        $users = User::all(); //Mengambil semua data User

        if(count($users) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $users
            ], 200);
        } //Return data semua User dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data User kosong
    }

    //Method untuk menampilkan 1 data User (SEARCH)
    public function show($id){
        $users = User::find($id); //Mencari data User berdasarkan id

        if(!is_null($users)){
            return response([
                'message' => 'Retrieve User Success',
                'data' => $users
            ], 200);
        } //Return data semua User dalam bentuk JSON

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 400); //Return message data User kosong
    }

    //Method untuk menambah 1 data User baru (CREATE)
    public function store(Request $request){
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'nomorIdentitas' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
        ]); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }
        $storeData['password'] = bcrypt($request->password);
        $User = User::create($storeData);

        return response([
            'message' => 'Add User Success',
            'data' => $User
        ], 200); //Return message data User baru dalam bentuk JSON
    }

    //Method untuk menghapus 1 data product (DELETE)
    public function destroy($id){
        $User = User::find($id); //Mencari data product berdasarkan id

        if(is_null($User)){
            return response([
                'message' => 'User Not Found',
                'date' => null
            ], 404);
        } //Return message saat data User tidak ditemukan

        if($User->delete()){
            return response([
                'message' => 'Delete User Success',
                'data' => $User
            ], 200);
        } //Return message saat berhasil menghapus data User

        return response([
            'message' => 'Delete User Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data User (UPDATE)
    public function update(Request $request, $id){
        $User = User::find($id); //Mencari data User berdasarkan id

        if(is_null($User)){
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        } //Return message saat data User tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns',
            'nomorIdentitas' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $User->name = $updateData['name']; //Edit Nama Kelas
        $User->email = $updateData['email']; //Edit email
        $User->nomorIdentitas = $updateData['nomorIdentitas']; //Edit email
        $User->username = $updateData['username']; //Edit email
        $User->password = bcrypt($updateData['password']);//Edit Biaya Pendaftaran

        if($User->save()){
            return response([
                'message' => 'Update User Success',
                'data' => $User
            ], 200);
        } //Return data User yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update User Failed',
            'data' => null
        ], 400);
    }
}
