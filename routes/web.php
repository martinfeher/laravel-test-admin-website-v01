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

    Route::get('/admin/user-management', 'UserManagementController@index'); // User Management stranka

    //  Produkty
    Route::get('/produkty', '\App\Http\Controllers\ProduktyController@index'); // produkty stranka
    Route::get('/produkty/tabulka-data', '\App\Http\Controllers\ProduktyController@tabulkaData'); // produkty stranka, tabulka data, ajax call
    Route::get('/produkty/tabulka-pridat-data', '\App\Http\Controllers\ProduktyController@tabulkaPridatData'); // produkty stranka, tabulka pridať riadok, ajax call
    Route::get('/produkty/tabulka-upravit-data', '\App\Http\Controllers\ProduktyController@tabulkaUpravitData'); // produkty stranka, tabulka upraviť riadok, ajax call
    Route::get('/produkty/tabulka-uprava-data', '\App\Http\Controllers\ProduktyController@tabulkaUpravaData'); // produkty stranka, tabulka uprava dat, ajax call
    Route::get('/produkty/vytvorit-objednavku', '\App\Http\Controllers\ProduktyController@vytvoritObjednavku'); // produkty stranka, vytvorit objednavku, ajax call
    Route::get('/produkty/tabulka-vymazat-data', '\App\Http\Controllers\ProduktyController@tabulkaVymazatData'); // produkty stranka, tabulka vymazať riadok, ajax call
    //  Koniec Produkty

    //  Objednavky
    Route::get('/objednavky', '\App\Http\Controllers\ObjednavkyController@index'); // objednavky stranka
    Route::get('/objednavky/tabulka-data', '\App\Http\Controllers\ObjednavkyController@tabulkaData'); // objednavky stranka, tabulka data, ajax call
    Route::post('/objednavky/tabulka-pridat-data', '\App\Http\Controllers\ObjednavkyController@tabulkaPridatData'); // objednavky stranka, tabulka pridať riadok, ajax call
    Route::get('/objednavky/tabulka-upravit-data', '\App\Http\Controllers\ObjednavkyController@tabulkaUpravitData'); // objednavky stranka, tabulka upraviť riadok, ajax call
    Route::get('/objednavky/tabulka-uprava-data', '\App\Http\Controllers\ObjednavkyController@tabulkaUpravaData'); // objednavky stranka, tabulka uprava dat, ajax call
    Route::get('/objednavky/tabulka-vymazat-data', '\App\Http\Controllers\ObjednavkyController@tabulkaVymazatData'); // objednavky stranka, tabulka vymazať riadok, ajax call

//    Route::get('/objednavky/image-upload', [ ObjednavkyController::class, 'imageUpload' ])->name('image.upload');
//    Route::post('/objednavky/image-upload', [ ObjednavkyController::class, 'imageUploadPost' ])->name('image.upload.post');
    Route::post('/objednavky/image-upload', '\App\Http\Controllers\ObjednavkyController@imageUploadPost')->name('image.upload.post');

    //  Koniec Objednavky

    //  Pouzivatelia
    Route::get('/pouzivatelia', '\App\Http\Controllers\PouzivateliaController@index'); // pouzivatelia stranka
    Route::get('/pouzivatelia/tabulka-data', '\App\Http\Controllers\PouzivateliaController@tabulkaData'); // pouzivatelia stranka, tabulka data, ajax call
    Route::get('/pouzivatelia/tabulka-pridat-data', '\App\Http\Controllers\PouzivateliaController@tabulkaPridatData'); // pouzivatelia stranka, tabulka pridať riadok, ajax call
    Route::get('/pouzivatelia/tabulka-upravit-data', '\App\Http\Controllers\PouzivateliaController@tabulkaUpravitData'); // pouzivatelia stranka, tabulka upraviť riadok, ajax call
    Route::get('/pouzivatelia/tabulka-uprava-data', '\App\Http\Controllers\PouzivateliaController@tabulkaUpravaData'); // pouzivatelia stranka, tabulka uprava dat, ajax call
    Route::get('/pouzivatelia/tabulka-vymazat-data', '\App\Http\Controllers\PouzivateliaController@tabulkaVymazatData'); // pouzivatelia stranka, tabulka vymazať riadok, ajax call
    //  Koniec Pouzivatelia

    Route::get('/odhlasit', '\App\Http\Controllers\Auth\LoginController@logout'); // Logout link

});
