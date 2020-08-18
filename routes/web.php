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
//Auth::routes(['register'=>false,'reset'=>false]);

//accesos para los usuarios que no estan autenticados
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/', 'Auth\LoginController@login')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
});
//---------------------------------------------------------------------------//

//accesos para los usuarios que si estan autenticados
    Route::group(['middleware' => ['auth']], function () {

        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('/principal', function () {
            return view('contenido/contenido');
        })->name('principal');
//---------------------------------------------------------------------------//

//accesos para los usuarios que son superadministrador

    Route::group(['middleware' => ['Superadministrador']], function () {

        Route::get("/rol", "Tb_rolController@index");

        Route::get("/area", "Tb_areaController@index");
        Route::post("/area/store", "Tb_areaController@store");
        Route::put("/area/update", "Tb_areaController@update");
        Route::put("/area/deactivate", "Tb_areaController@deactivate");
        Route::put("/area/activate", "Tb_areaController@activate");
        Route::get("/area/selectArea", "Tb_areaController@selectArea");

        Route::get("/proceso", "Tb_procesoController@index");
        Route::post("/proceso/store", "Tb_procesoController@store");
        Route::put("/proceso/update", "Tb_procesoController@update");
        Route::put("/proceso/deactivate", "Tb_procesoController@deactivate");
        Route::put("/proceso/activate", "Tb_procesoController@activate");
        Route::get("/proceso/selectProceso", "Tb_procesoController@selectProceso");

        Route::get("/perfil", "Tb_perfilController@index");
        Route::post("/perfil/store", "Tb_perfilController@store");
        Route::put("/perfil/update", "Tb_perfilController@update");
        Route::put("/perfil/deactivate", "Tb_perfilController@deactivate");
        Route::put("/perfil/activate", "Tb_perfilController@activate");
        Route::get("/perfil/selectRelacion", "Tb_perfilController@selectRelacion");

        Route::get("/unidad", "Tb_unidad_baseController@index");
        Route::post("/unidad/store", "Tb_unidad_baseController@store");
        Route::put("/unidad/update", "Tb_unidad_baseController@update");
        Route::put("/unidad/deactivate", "Tb_unidad_baseController@deactivate");
        Route::put("/unidad/activate", "Tb_unidad_baseController@activate");
        Route::get("/unidad/selectUnidad", "Tb_unidad_baseController@selectUnidad");

        Route::get("/materia", "Tb_tipo_materiaController@index");
        Route::post("/materia/store", "Tb_tipo_materiaController@store");
        Route::put("/materia/update", "Tb_tipo_materiaController@update");
        Route::put("/materia/deactivate", "Tb_tipo_materiaController@deactivate");
        Route::put("/materia/activate", "Tb_tipo_materiaController@activate");
        Route::get("/materia/selectUnidad", "Tb_tipo_materiaController@selectUnidad");

        Route::get("/coleccion", "Tb_coleccionController@index");
        Route::post("/coleccion/store", "Tb_coleccionController@store");
        Route::put("/coleccion/update", "Tb_coleccionController@update");
        Route::put("/coleccion/deactivate", "Tb_coleccionController@deactivate");
        Route::put("/coleccion/activate", "Tb_coleccionController@activate");
        Route::get("/coleccion/selectColeccion", "Tb_coleccionController@selectColeccion");

        Route::get("/rol/create", "Tb_rolController@create");
        Route::get("/rol/store", "Tb_rolController@store");
        Route::get("/rol/{id?}/edit", "Tb_rolController@edit");
        Route::get("/rol/{id?}/update", "Tb_rolController@update");
        Route::get("/rol/{id?}/deactivate", "Tb_rolController@deactivate");

    });

//---------------------------------------------------------------------------//

//accesos para los usuarios que son empresarios


    Route::group(['middleware' => ['Empresario']], function () {
        //accesos para los usuarios que son empresarios

        Route::get("/proceso", "Tb_procesoController@index");
        Route::post("/proceso/store", "Tb_procesoController@store");
        Route::put("/proceso/update", "Tb_procesoController@update");
        Route::put("/proceso/deactivate", "Tb_procesoController@deactivate");
        Route::put("/proceso/activate", "Tb_procesoController@activate");
        Route::get("/proceso/selectProceso", "Tb_procesoController@selectProceso");

        Route::get("/perfil", "Tb_perfilController@index");
        Route::post("/perfil/store", "Tb_perfilController@store");
        Route::put("/perfil/update", "Tb_perfilController@update");
        Route::put("/perfil/deactivate", "Tb_perfilController@deactivate");
        Route::put("/perfil/activate", "Tb_perfilController@activate");

        Route::get("/unidad", "Tb_unidad_baseController@index");
        Route::post("/unidad/store", "Tb_unidad_baseController@store");
        Route::put("/unidad/update", "Tb_unidad_baseController@update");
        Route::put("/unidad/deactivate", "Tb_unidad_baseController@deactivate");
        Route::put("/unidad/activate", "Tb_unidad_baseController@activate");
        Route::get("/unidad/selectUnidad", "Tb_unidad_baseController@selectUnidad");

        Route::get("/materia", "Tb_tipo_materiaController@index");
        Route::post("/materia/store", "Tb_tipo_materiaController@store");
        Route::put("/materia/update", "Tb_tipo_materiaController@update");
        Route::put("/materia/deactivate", "Tb_tipo_materiaController@deactivate");
        Route::put("/materia/activate", "Tb_tipo_materiaController@activate");
        Route::get("/materia/selectUnidad", "Tb_tipo_materiaController@selectUnidad");

        Route::get("/coleccion", "Tb_coleccionController@index");
        Route::post("/coleccion/store", "Tb_coleccionController@store");
        Route::put("/coleccion/update", "Tb_coleccionController@update");
        Route::put("/coleccion/deactivate", "Tb_coleccionController@deactivate");
        Route::put("/coleccion/activate", "Tb_coleccionController@activate");
        Route::get("/coleccion/selectColeccion", "Tb_coleccionController@selectColeccion");

    });
//---------------------------------------------------------------------------//

//Prueba para las rutas de coleccion

    Route::resource('coleccion','Tb_coleccionController');


//---------------------------------------------------------------------------//

//Prueba para las rutas de producto

    Route::resource('producto','Tb_productoController');
    Route::get('producto/create/{id}', 'Tb_productoController@create');

});

//---------------------------------------------------------------------------//
