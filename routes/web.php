<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    if (Auth::guest()) {
        return redirect('/login');
    } else {
        return redirect('/produkty');
//        return redirect('/home');
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {

    Route::get('/admin/user-management', 'UserManagementController@index'); // User Management stranka

    Route::get('/produkty', '\App\Http\Controllers\ProduktyController@index'); // produkty stranka
    Route::get('/produkty/tabulka-data', '\App\Http\Controllers\ProduktyController@tabulkaData'); // produkty tabulka data, ajax call

    Route::get('/objednavky', '\App\Http\Controllers\ObjednavkyController@index'); // objednavky stranka


    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout'); // Logout link


});
