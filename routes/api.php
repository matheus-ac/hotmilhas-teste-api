<?php

use Illuminate\Http\Request;

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
Route::get('/getmarcas/{id}', 'ApiController@getMarcas');
Route::get('/getmodelos/{id}', 'ApiController@getModelos');
Route::post('/getcidades', 'ApiController@getCidades');
Route::post('/getsearch', 'ApiController@getSearch');
Route::get('/detalhes/{id}', 'ApiController@getDetalhes');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
