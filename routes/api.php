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

Route::middleware('auth:api')->group(function () {
    Route::post('logout','LoginControllerAPI@logout');

    Route::get('users/me', 'UserControllerAPI@myProfile');
    Route::get('users/startShift', 'UserControllerAPI@startShift');
    Route::get('users/endShift', 'UserControllerAPI@endShift');
    Route::get('users', 'UserControllerAPI@index');
    Route::post('users/edit/{id?}', 'UserControllerAPI@update');
    Route::post('users', 'UserControllerAPI@store');
    Route::delete('users/{id}', 'UserControllerAPI@destroy');
    Route::get('users/{id}', 'UserControllerAPI@show');

    Route::post('sendMail/{id}', 'UserControllerAPI@sendRegistrationMail');

    Route::get('drink_items', 'ItemControllerAPI@drink');
    Route::get('dish_items', 'ItemControllerAPI@dish');
    Route::get('items/{id}', 'ItemControllerAPI@show');
    Route::post('items', 'ItemControllerAPI@store');
    Route::put('items/{id}', 'ItemControllerAPI@update');
    Route::delete('items/{id}', 'ItemControllerAPI@destroy');

    Route::get('pending/orders', 'OrderControllerAPI@pending');
    Route::get('orders/{id?}', 'OrderControllerAPI@index');
    Route::get('pending_confirmed_orders', 'OrderControllerAPI@pendingconfirmed');
    Route::get('orders/{id}', 'OrderControllerAPI@show');
    Route::post('orders', 'OrderControllerAPI@store');
    Route::put('orders/{id}', 'OrderControllerAPI@update');
    Route::delete('orders/{id}', 'OrderControllerAPI@destroy');

    Route::get('meals', 'MealControllerAPI@index');
    Route::get('meals/{id?}', 'MealControllerAPI@active');
    Route::get('meals/{id}', 'MealControllerAPI@show');
    Route::post('meals', 'MealControllerAPI@store');
    Route::put('meals/{id}', 'MealControllerAPI@update');

    Route::get('invoices', 'InvoiceControllerAPI@index');
    Route::get('all', 'InvoiceControllerAPI@all');
    Route::get('invoices/paid', 'InvoiceControllerAPI@paid');
    Route::get('invoices/notpaid', 'InvoiceControllerAPI@notpaid');
    Route::get('invoices/{id}', 'InvoiceControllerAPI@show');
    Route::post('invoices', 'InvoiceControllerAPI@store');
    Route::put('invoices/{id}', 'InvoiceControllerAPI@update');

    Route::get('restaurant_tables', 'TableControllerAPI@index');
    Route::get('restaurant_tables/{id}', 'TableControllerAPI@show');
    Route::post('restaurant_tables', 'TableControllerAPI@store');
    Route::put('restaurant_tables/{id}', 'TableControllerAPI@update');


});

Route::get('users/confirm/{id}', 'UserControllerAPI@confirmUser');

/*Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');*/


Route::get('items', 'ItemControllerAPI@index');

Route::post('login', 'LoginControllerAPI@login');




/*
Caso prefiram usar Resource Routes para o user, podem implementar antes as rotas:
NOTA: neste caso, o parâmetro a receber nos métodos do controlador é user e não id

Route::apiResource('users','UserControllerAPI');
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
*/
