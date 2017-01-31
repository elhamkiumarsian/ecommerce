<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


use App\User;

Route::get('/', function(){
    return redirect(asset('Auth/Login'));
});


Route::get('Products/Add', 'ProductsController@create');
Route::post('Products/Add', 'ProductsController@store');
Route::get('Products','ProductsController@index');
Route:get('Products/Show/{id}','ProductsController@show');

Route::get('Orders/View','OrdersController@viewOrders');
Route::get('Orders','OrdersController@index');
Route::get('Orders/Delete/{id}','OrdersController@destroy');
Route::get('Orders/Update/{id}','OrdersController@edit');
Route::post('Orders/Update/{id}','OrdersController@update');
Route::get('Orders/Finalize','OrdersController@finalizeOrder');

// Ajax
Route::post('Order/Add','OrdersController@addItemToBasket');

Route::get('/Products/GetParents/{id}', function ($id) {
    $parents = \App\Product::where('parent','=',$id)->get(['id','name']);

});


// Authentication routes...
Route::get('Auth/Login', 'Auth\AuthController@getLogin');
Route::post('Auth/Login', 'Auth\AuthController@postLogin');
Route::get('Auth/Logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('Auth/Register', 'Auth\AuthController@getRegister');
Route::post('Auth/Register', 'Auth\AuthController@postRegister');

Route::get('test',function(){
   dd(User::getRole()) ;
});