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
    }
});

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    //  Produkty
    Route::get('/produkty', '\App\Http\Controllers\ProduktyController@index'); // produkty stranka
    Route::get('/produkty/tabulka-data', '\App\Http\Controllers\ProduktyController@tabulkaData'); // produkty stranka, tabulka data, Ajax call
    Route::get('/produkty/pridat-zaznam', '\App\Http\Controllers\ProduktyController@pridatZaznam'); // produkty stranka, pridať zaznam, Ajax call
    Route::get('/produkty/data-pre-upravu-zaznamu', '\App\Http\Controllers\ProduktyController@dataPreUpravuZaznamu'); // produkty stranka, pridat data pre upravu zaznamu, Ajax call
    Route::get('/produkty/upravit-zaznam', '\App\Http\Controllers\ProduktyController@upravitZaznam'); // produkty stranka, upravit data, Ajax call
    Route::get('/produkty/vytvorit-objednavku', '\App\Http\Controllers\ProduktyController@vytvoritObjednavku'); // produkty stranka, vytvorit objednavku, Ajax call
    Route::get('/produkty/vymazat-data', '\App\Http\Controllers\ProduktyController@vymazatData'); // produkty stranka, vymazať zaznam, Ajax call
    //  Koniec Produkty

    //  Objednavky
    Route::get('/objednavky', '\App\Http\Controllers\ObjednavkyController@index'); // objednavky stranka
    Route::get('/objednavky/tabulka-data', '\App\Http\Controllers\ObjednavkyController@tabulkaData'); // objednavky stranka, tabulka data, Ajax call
    Route::post('/objednavky/pridat-zaznam', '\App\Http\Controllers\ObjednavkyController@pridatZaznam'); // objednavky stranka, pridať zaznam, Ajax call
    Route::get('/objednavky/data-pre-upravu-zaznamu', '\App\Http\Controllers\ObjednavkyController@dataPreUpravuZaznamu'); // objednavky stranka, pridat data pre upravu zaznamu, Ajax call
    Route::post('/objednavky/upravit-zaznam', '\App\Http\Controllers\ObjednavkyController@upravitZaznam'); // objednavky stranka, upravit data, Ajax call
    Route::get('/objednavky/vymazat-data', '\App\Http\Controllers\ObjednavkyController@vymazatData'); // objednavky stranka, vymazať zaznam, Ajax call
    //  Koniec Objednavky

    //  Pouzivatelia
    Route::group(['middleware' => ['can:adminZona']], function() {
        // Administrator iba moze pristupit k stranke pouzivatelom
        Route::get('/pouzivatelia', '\App\Http\Controllers\PouzivateliaController@index'); // pouzivatelia stranka
        Route::get('/pouzivatelia/tabulka-data', '\App\Http\Controllers\PouzivateliaController@tabulkaData'); // pouzivatelia stranka, tabulka data, Ajax call
        Route::get('/pouzivatelia/vymazat-data', '\App\Http\Controllers\PouzivateliaController@vymazatData'); // pouzivatelia stranka, vymazať zaznam, Ajax call
    });
    //  Koniec Pouzivatelia

    Route::get('/odhlasit', '\App\Http\Controllers\Auth\LoginController@logout'); // Logout link

});
