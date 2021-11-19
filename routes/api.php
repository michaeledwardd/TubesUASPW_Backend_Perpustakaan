<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('buku', 'Api\bukuController@index');
    Route::get('buku/{id}', 'Api\bukuController@show');
    Route::post('buku', 'Api\bukuController@store');
    Route::put('buku/{id}', 'Api\bukuController@update');
    Route::delete('buku/{id}', 'Api\bukuController@destroy');
});


// Route::group(['middleware' => 'auth:api'], function(){
//     Route::get('student', 'Api\StudentController@index');
//     Route::get('student/{id}', 'Api\StudentController@show');
//     Route::post('student', 'Api\StudentController@store');
//     Route::put('student/{id}', 'Api\StudentController@update');
//     Route::delete('student/{id}', 'Api\StudentController@destroy');
// });