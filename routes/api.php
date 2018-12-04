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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', 'UserControllerAPI@index');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
Route::get('users/{id}', 'UserControllerAPI@show');
Route::post('users', 'UserControllerAPI@store');
Route::put('users/{id}', 'UserControllerAPI@update');
Route::delete('users/{id}', 'UserControllerAPI@destroy');

Route::get('items', 'ItemControllerAPI@index');
Route::get('items/{id}', 'ItemControllerAPI@show');
Route::post('items', 'ItemControllerAPI@store');
Route::put('items/{id}', 'ItemControllerAPI@update');
Route::delete('items/{id}', 'ItemControllerAPI@destroy');

Route::get('orders', 'OrderControllerAPI@pending');
//Route::get('pendingorders', 'OrderControllerAPI@pending');
Route::get('orders/{id}', 'OrderControllerAPI@show');
Route::post('orders', 'OrderControllerAPI@store');
Route::put('orders/{id}', 'OrderControllerAPI@update');
Route::delete('orders/{id}', 'OrderControllerAPI@destroy');


/*
Caso prefiram usar Resource Routes para o user, podem implementar antes as rotas:
NOTA: neste caso, o parâmetro a receber nos métodos do controlador é user e não id

Route::apiResource('users','UserControllerAPI');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
*/
