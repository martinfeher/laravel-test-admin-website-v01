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
    Route::get('/produkty/tabulka-pridat-data', '\App\Http\Controllers\ProduktyController@tabulkaPridatData'); // produkty stranka, tabulka pridať zaznam, Ajax call
    Route::get('/produkty/tabulka-upravit-data', '\App\Http\Controllers\ProduktyController@tabulkaUpravitData'); // produkty stranka, tabulka upraviť zaznam, Ajax call
    Route::get('/produkty/tabulka-uprava-data', '\App\Http\Controllers\ProduktyController@tabulkaUpravaData'); // produkty stranka, tabulka uprava dat, Ajax call
    Route::get('/produkty/vytvorit-objednavku', '\App\Http\Controllers\ProduktyController@vytvoritObjednavku'); // produkty stranka, vytvorit objednavku, Ajax call
    Route::get('/produkty/tabulka-vymazat-data', '\App\Http\Controllers\ProduktyController@tabulkaVymazatData'); // produkty stranka, tabulka vymazať zaznam, Ajax call
    //  Koniec Produkty

    //  Objednavky
    Route::get('/objednavky', '\App\Http\Controllers\ObjednavkyController@index'); // objednavky stranka
    Route::get('/objednavky/tabulka-data', '\App\Http\Controllers\ObjednavkyController@tabulkaData'); // objednavky stranka, tabulka data, Ajax call
    Route::post('/objednavky/tabulka-pridat-data', '\App\Http\Controllers\ObjednavkyController@tabulkaPridatData'); // objednavky stranka, tabulka pridať zaznam, Ajax call
    Route::post('/objednavky/tabulka-upravit-data', '\App\Http\Controllers\ObjednavkyController@tabulkaUpravitData'); // objednavky stranka, tabulka upraviť zaznam, Ajax call
    Route::get('/objednavky/tabulka-uprava-data', '\App\Http\Controllers\ObjednavkyController@tabulkaUpravaData'); // objednavky stranka, tabulka uprava dat, Ajax call
    Route::get('/objednavky/tabulka-vymazat-data', '\App\Http\Controllers\ObjednavkyController@tabulkaVymazatData'); // objednavky stranka, tabulka vymazať zaznam, Ajax call
    //  Koniec Objednavky

    //  Pouzivatelia
    Route::group(['middleware' => ['can:adminZona']], function() {
        // Administrator iba moze pristupit k stranke pouzivatelom
        Route::get('/pouzivatelia', '\App\Http\Controllers\PouzivateliaController@index'); // pouzivatelia stranka
        Route::get('/pouzivatelia/tabulka-data', '\App\Http\Controllers\PouzivateliaController@tabulkaData'); // pouzivatelia stranka, tabulka data, Ajax call
        Route::get('/pouzivatelia/tabulka-vymazat-data', '\App\Http\Controllers\PouzivateliaController@tabulkaVymazatData'); // pouzivatelia stranka, tabulka vymazať zaznam, Ajax call
    });
    //  Koniec Pouzivatelia

    Route::get('/odhlasit', '\App\Http\Controllers\Auth\LoginController@logout'); // Logout link

});
