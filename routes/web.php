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
        Route::get("/perfil/selectRelacion/{id}", "Tb_perfilController@selectRelacion");

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
        Route::get("/materia/selectUnidad", "Tb_tipo_materiaController@selectMateria");

        Route::get("/gestionmateria", "Tb_gestion_materia_primaController@index");
        Route::post("/gestionmateria/store", "Tb_gestion_materia_primaController@store");
        Route::put("/gestionmateria/update", "Tb_gestion_materia_primaController@update");
        Route::put("/gestionmateria/deactivate", "Tb_gestion_materia_primaController@deactivate");
        Route::put("/gestionmateria/activate", "Tb_gestion_materia_primaController@activate");
        Route::get("/gestionmateria/selectTipoMateria", "Tb_gestion_materia_primaController@selectTipoMateria");
        Route::get("/gestionmateria/selectUnidadBase", "Tb_gestion_materia_primaController@selectUnidadBase");

        Route::get("/coleccion", "Tb_coleccionController@index");
        Route::post("/coleccion/store", "Tb_coleccionController@store");
        Route::put("/coleccion/update", "Tb_coleccionController@update");
        Route::put("/coleccion/deactivate", "Tb_coleccionController@deactivate");
        Route::put("/coleccion/activate", "Tb_coleccionController@activate");
        Route::get("/coleccion/selectColeccion", "Tb_coleccionController@selectColeccion");

        Route::get("/producto", "Tb_productoController@index");
        Route::post("/producto/store", "Tb_productoController@store");
        Route::put("/producto/update", "Tb_productoController@update");
        Route::put("/producto/deactivate", "Tb_productoController@deactivate");
        Route::put("/producto/activate", "Tb_productoController@activate");
        Route::get("/producto/selectProducto", "Tb_productoController@selectProducto");

        Route::get("/rol", "Tb_rolController@index");
        Route::post("/rol/store", "Tb_rolController@store");
        Route::put("/rol/update", "Tb_rolController@update");
        Route::put("/rol/deactivate", "Tb_rolController@deactivate");
        Route::put("/rol/activate", "Tb_rolController@activate");
        Route::get("/rol/selectRol", "Tb_rolController@selectRol");

        Route::get("/usuario", "UserController@index");
        Route::post("/usuario/store", "UserController@store");
        Route::put("/usuario/update", "UserController@update");
        Route::put("/usuario/deactivate", "UserController@deactivate");
        Route::put("/usuario/activate", "UserController@activate");
        Route::get("/usuario/selectUsuario", "UserController@selectUsuario");

        Route::get("/manodeobraproducto", "Tb_mano_de_obra_productoController@index");
        Route::post("/manodeobraproducto/store", "Tb_mano_de_obra_productoController@store");
        Route::put("/manodeobraproducto/update", "Tb_mano_de_obra_productoController@update");
        Route::put("/manodeobraproducto/deactivate", "Tb_mano_de_obra_productoController@deactivate");
        Route::put("/manodeobraproducto/activate", "Tb_mano_de_obra_productoController@activate");
        Route::get("/manodeobraproducto/selectManoDeObraProducto", "Tb_mano_de_obra_productoController@selectManoDeObraProducto");

        Route::get("/materiaprimaproducto", "Tb_materia_prima_productoController@index");
        Route::post("/materiaprimaproducto/store", "Tb_materia_prima_productoController@store");
        Route::put("/materiaprimaproducto/update", "Tb_materia_prima_productoController@update");
        Route::put("/materiaprimaproducto/deactivate", "Tb_materia_prima_productoController@deactivate");
        Route::put("/materiaprimaproducto/activate", "Tb_materia_prima_productoController@activate");
        Route::get("/materiaprimaproducto/selectMateriaPrimaProducto", "Tb_materia_prima_productoController@selectMateriaPrimaProducto");

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
        Route::get("/materia/selectUnidad", "Tb_tipo_materiaController@selectMateria");

        Route::get("/gestionmateria", "Tb_gestion_materia_primaController@index");
        Route::post("/gestionmateria/store", "Tb_gestion_materia_primaController@store");
        Route::put("/gestionmateria/update", "Tb_gestion_materia_primaController@update");
        Route::put("/gestionmateria/deactivate", "Tb_gestion_materia_primaController@deactivate");
        Route::put("/gestionmateria/activate", "Tb_gestion_materia_primaController@activate");
        Route::get("/gestionmateria/selectUnidad", "Tb_gestion_materia_primaController@selectGestionMateria");

        Route::get("/coleccion", "Tb_coleccionController@index");
        Route::post("/coleccion/store", "Tb_coleccionController@store");
        Route::put("/coleccion/update", "Tb_coleccionController@update");
        Route::put("/coleccion/deactivate", "Tb_coleccionController@deactivate");
        Route::put("/coleccion/activate", "Tb_coleccionController@activate");
        Route::get("/coleccion/selectColeccion", "Tb_coleccionController@selectColeccion");

        Route::get("/producto", "Tb_productoController@index");
        Route::post("/producto/store", "Tb_productoController@store");
        Route::put("/producto/update", "Tb_productoController@update");
        Route::put("/producto/deactivate", "Tb_productoController@deactivate");
        Route::put("/producto/activate", "Tb_productoController@activate");
        Route::get("/producto/selectProducto", "Tb_productoController@selectProducto");

    });

});


