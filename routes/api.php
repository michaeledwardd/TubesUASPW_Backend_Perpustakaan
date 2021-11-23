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

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('buku', 'Api\bukuController@index');
    Route::get('buku/{id}', 'Api\bukuController@show');
    Route::post('buku', 'Api\bukuController@store');
    Route::put('buku/{id}', 'Api\bukuController@update');
    Route::delete('buku/{id}', 'Api\bukuController@destroy');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('denda', 'Api\dendaController@index');
    Route::get('denda/{id}', 'Api\dendaController@show');
    Route::post('denda', 'Api\dendaController@store');
    Route::put('denda/{id}', 'Api\dendaController@update');
    Route::delete('denda/{id}', 'Api\dendaController@destroy');
});