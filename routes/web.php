<?php

use Illuminate\Support\Facades\Auth;
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
//Route::get('/', 'Auth\LoginController@showLoginForm');

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/', 'Auth\LoginController@login')->name('login');
    //accesos para los usuarios que no estan autenticados
});

Route::group(['middleware' => ['auth']], function () {
    //accesos para los usuarios que si estan autenticados

    Route::group(['middleware' => ['Superadministrador']], function () {
        //accesos para los usuarios que son superadministrador
    });

    Route::group(['middleware' => ['Superadministrador']], function () {
        //accesos para los usuarios que son empresarios
    });

    Route::get('/principal', function () {
        return view('contenido/contenido');
    })->name('principal');

    Auth::routes(['register'=>false,'reset'=>false]);

    Route::get("/area", "Tb_areaController@index");
    Route::get("/proceso", "Tb_procesoController@index");
    Route::get("/perfil", "Tb_perfilController@index");
    Route::get("/rol", "Tb_rolController@index");
    Route::get("/unidad", "Tb_unidad_baseController@index");
    Route::get("/tipomateria", "Tb_tipo_materiaController@index");

    Route::get("/area/create", "Tb_areaController@create");
    Route::get("/area/store", "Tb_areaController@store");
    Route::get("/area/{id?}/edit", "Tb_areaController@edit");
    Route::get("/area/{id?}/update", "Tb_areaController@update");
    Route::get("/area/{id?}/deactivate", "Tb_areaController@deactivate");

    Route::get("/proceso/create", "Tb_procesoController@create");
    Route::get("/proceso/store", "Tb_procesoController@store");
    Route::get("/proceso/{id?}/edit", "Tb_procesoController@edit");
    Route::get("/proceso/{id?}/update", "Tb_procesoController@update");
    Route::get("/proceso/{id?}/deactivate", "Tb_procesoController@deactivate");

    Route::get("/perfil/create", "Tb_perfilController@create");
    Route::get("/perfil/store", "Tb_perfilController@store");
    Route::get("/perfil/{id?}/edit", "Tb_perfilController@edit");
    Route::get("/perfil/{id?}/update", "Tb_perfilController@update");
    Route::get("/perfil/{id?}/deactivate", "Tb_perfilController@deactivate");

    Route::get("/rol/create", "Tb_rolController@create");
    Route::get("/rol/store", "Tb_rolController@store");
    Route::get("/rol/{id?}/edit", "Tb_rolController@edit");
    Route::get("/rol/{id?}/update", "Tb_rolController@update");
    Route::get("/rol/{id?}/deactivate", "Tb_rolController@deactivate");

    Route::get("/unidad/create", "Tb_unidad_baseController@create");
    Route::get("/unidad/store", "Tb_unidad_baseController@store");
    Route::get("/unidad/{id?}/edit", "Tb_unidad_baseController@edit");
    Route::get("/unidad/{id?}/update", "Tb_unidad_baseController@update");
    Route::get("/unidad/{id?}/deactivate", "Tb_unidad_baseController@deactivate");

    Route::get("/tipomateria/create", "Tb_tipo_materiaController@create");
    Route::get("/tipomateria/store", "Tb_tipo_materiaController@store");
    Route::get("/tipomateria/{id?}/edit", "Tb_tipo_materiaController@edit");
    Route::get("/tipomateria/{id?}/update", "Tb_tipo_materiaController@update");
    Route::get("/tipomateria/{id?}/deactivate", "Tb_tipo_materiaController@deactivate");

});
