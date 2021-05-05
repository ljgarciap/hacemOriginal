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

        Route::get('/pruebas', function () {
            return view('home');
        })->name('pruebas');
//---------------------------------------------------------------------------//

//accesos para los usuarios que son superadministrador

    Route::group(['middleware' => ['Superadministrador']], function () {

        Route::get("/financiera", "Tb_informacion_financieraController@index");
        Route::post("/financiera/store", "Tb_informacion_financieraController@store");
        Route::put("/financiera/update", "Tb_informacion_financieraController@update");
        Route::put("/financiera/deactivate", "Tb_informacion_financieraController@deactivate");
        Route::put("/financiera/activate", "Tb_informacion_financieraController@activate");
        Route::post("/financiera/actualizar", "Tb_informacion_financieraController@actualizar");

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
        Route::get("/perfil/selectPerfil", "Tb_perfilController@selectPerfil");
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
        Route::get("/gestionmateria/selectGestionMateria", "Tb_gestion_materia_primaController@selectGestionMateria");

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
        Route::get("/manodeobraproducto/selectRelacionPerfil/{id}", "Tb_mano_de_obra_productoController@selectRelacionPerfil");
        Route::get("/manodeobraproducto/valorMinuto/{id}", "Tb_mano_de_obra_productoController@valorMinuto");

        Route::get("/materiaprimaproducto", "Tb_materia_prima_productoController@index");
        Route::post("/materiaprimaproducto/store", "Tb_materia_prima_productoController@store");
        Route::put("/materiaprimaproducto/update", "Tb_materia_prima_productoController@update");
        Route::put("/materiaprimaproducto/deactivate", "Tb_materia_prima_productoController@deactivate");
        Route::get("/materiaprimaproducto/selectMateriaPrimaProducto", "Tb_materia_prima_productoController@selectMateriaPrimaProducto");
        Route::get("/materiaprimaproducto/selectGestionMateria", "Tb_materia_prima_productoController@selectGestionMateria");
        Route::get("/materiaprimaproducto/valorPrecioBase/{id}", "Tb_materia_prima_productoController@valorPrecioBase");

        Route::get("/concepto", "Tb_concepto_cifController@index");
        Route::post("/concepto/store", "Tb_concepto_cifController@store");
        Route::put("/concepto/update", "Tb_concepto_cifController@update");
        Route::put("/concepto/deactivate", "Tb_concepto_cifController@deactivate");
        Route::put("/concepto/activate", "Tb_concepto_cifController@activate");
        Route::get("/concepto/selectConcepto", "Tb_concepto_cifController@selectConcepto");

        Route::get("/maquinaria", "Tb_maquinariaController@index");
        Route::post("/maquinaria/store", "Tb_maquinariaController@store");
        Route::put("/maquinaria/update", "Tb_maquinariaController@update");
        Route::put("/maquinaria/deactivate", "Tb_maquinariaController@deactivate");
        Route::put("/maquinaria/activate", "Tb_maquinariaController@activate");
        Route::get("/maquinaria/selectMaquinaria", "Tb_maquinariaController@selectMaquinaria");

        Route::get("/hojadecosto/total/{identificador}", "Hoja_De_CostosController@acumuladoTotal");
        Route::get("/hojadecosto/depreciacion/{identificador}", "Hoja_De_CostosController@maquinariaTotal");
        Route::get("/hojadecosto/ciftiempos/{identificador}", "Hoja_De_CostosController@cifTiempos");
        Route::get("/hojadecosto/unitario/", "Hoja_De_CostosController@unitarioTotal");
        Route::get("/hojadecosto/detalle/", "Hoja_De_CostosController@hojaDetalle");
        Route::get("/hojadecosto/unitariogen/", "Hoja_De_CostosController@unitarioTotalGen");
        Route::get("/hojadecosto/detallegen/", "Hoja_De_CostosController@hojaDetalleGen");

        Route::get("/simulacion", "Tb_simulacionController@index");
        Route::post("/simulacion/store", "Tb_simulacionController@store");
        Route::post("/simulacion/estado", "Tb_simulacionController@estado");
        Route::get("/simulacion/selectArea", "Tb_simulacionController@selectArea");
        Route::put("/simulacion/update", "Tb_simulacionController@update");
        Route::get("/simulacion/ciftiempos/{identificador}", "Tb_simulacionController@cifTiempos");
        Route::get("/simulacion/unitario/", "Tb_simulacionController@unitarioTotal");
        Route::get("/simulacion/detalle/", "Tb_simulacionController@hojaDetalle");
        Route::get("/simulacion/unitariogen/", "Tb_simulacionController@unitarioTotalGen");
        Route::get("/simulacion/detallegen/", "Tb_simulacionController@hojaDetalleGen");

        Route::get("/ordenpedido", "Tb_orden_pedido_clienteController@index");
        Route::post("/ordenpedido/store", "Tb_orden_pedido_clienteController@store");
        Route::post("/ordenpedido/estado", "Tb_orden_pedido_clienteController@estado");
        Route::get("/ordenpedido/clientes", "Tb_orden_pedido_clienteController@clientes");
        Route::put("/ordenpedido/update", "Tb_orden_pedido_clienteController@update");
        Route::get("/ordenpedido/ciftiempos/{identificador}", "Tb_orden_pedido_clienteController@cifTiempos");

        Route::get("/ordenpedidocliente", "Tb_orden_pedido_cliente_detalleController@index");
        Route::get("/ordenpedidocliente/listar", "Tb_orden_pedido_cliente_detalleController@listar");
        Route::get("/ordenpedidocliente/listarpendientes", "Tb_orden_pedido_cliente_detalleController@listarPendientes");
        Route::get("/ordenpedidocliente/listarsobrantes", "Tb_orden_pedido_cliente_detalleController@listarSobrantes");
        Route::get("/ordenpedidocliente/listarcompletos", "Tb_orden_pedido_cliente_detalleController@listarCompletos");
        Route::get("/ordenpedidocliente/posibles", "Tb_orden_pedido_cliente_detalleController@posibles");
        Route::get("/ordenpedidocliente/costo", "Tb_orden_pedido_cliente_detalleController@costo");
        Route::post("/ordenpedidocliente/store", "Tb_orden_pedido_cliente_detalleController@store");

        Route::get("/rela", "Tb_rela_simulacionController@index");
        Route::get("/rela/listar", "Tb_rela_simulacionController@listar");
        Route::get("/rela/posibles", "Tb_rela_simulacionController@posibles");
        Route::post("/rela/store", "Tb_rela_simulacionController@store");
        Route::get("/rela/selectArea", "Tb_rela_simulacionController@selectArea");
        Route::put("/rela/update", "Tb_rela_simulacionController@update");

        Route::get("/empleado", "Tb_empleadoController@index");
        Route::post("/empleado/store", "Tb_empleadoController@store");
        Route::put("/empleado/update", "Tb_empleadoController@update");
        Route::put("/empleado/deactivate", "Tb_empleadoController@deactivate");
        Route::put("/empleado/activate", "Tb_empleadoController@activate");
        Route::get("/empleado/selectEmpleado", "Tb_empleadoController@selectEmpleado");
        Route::get("/empleado/selectRelacion/{id}", "Tb_empleadoController@selectRelacion");

        Route::get("/cliente", "Tb_clienteController@index");
        Route::post("/cliente/store", "Tb_clienteController@store");
        Route::put("/cliente/update", "Tb_clienteController@update");
        Route::put("/cliente/deactivate", "Tb_clienteController@deactivate");
        Route::put("/cliente/activate", "Tb_clienteController@activate");
        Route::get("/cliente/selectCliente", "Tb_clienteController@selectCliente");

        Route::get("/proveedor", "Tb_proveedorController@index");
        Route::post("/proveedor/store", "Tb_proveedorController@store");
        Route::put("/proveedor/update", "Tb_proveedorController@update");
        Route::put("/proveedor/deactivate", "Tb_proveedorController@deactivate");
        Route::put("/proveedor/activate", "Tb_proveedorController@activate");
        Route::get("/proveedor/selectProveedor", "Tb_proveedorController@selectProveedor");

        Route::get("/cotizacion", "Tb_cotizacionController@index");
        Route::post("/cotizacion/store", "Tb_cotizacionController@store");
        Route::post("/cotizacion/estado", "Tb_cotizacionController@estado");
        Route::put("/cotizacion/update", "Tb_cotizacionController@update");
        Route::get("/cotizacion/clientes", "Tb_cotizacionController@clientes");

        Route::get("/cotizacioncliente", "Tb_detalle_cotizacionController@index");
        Route::get("/cotizacioncliente/listar", "Tb_detalle_cotizacionController@listar");
        Route::get("/cotizacioncliente/posibles", "Tb_detalle_cotizacionController@posibles");
        Route::post("/cotizacioncliente/store", "Tb_detalle_cotizacionController@store");

        Route::get("/kardexproductogeneral", "Tb_kardex_producto_terminadoController@general");
        Route::get("/kardexproducto", "Tb_kardex_producto_terminadoController@index");
        Route::get("/kardexproducto/listar", "Tb_kardex_producto_terminadoController@listar");
        Route::get("/kardexproductoordenes", "Tb_kardex_producto_terminadoController@ordenes");
        Route::get("/kardexproducto/material/{identificador}", "Tb_kardex_producto_terminadoController@material");
        Route::get("/kardexproducto/preciomaterialorden", "Tb_kardex_producto_terminadoController@preciomaterialorden");
        Route::get("/kardexproducto/preciomaterialcompra", "Tb_kardex_producto_terminadoController@preciomaterialcompra");
        Route::get("/kardexproducto/factura", "Tb_kardex_producto_terminadoController@factura");
        Route::get("/kardexproducto/materialfactura", "Tb_kardex_producto_terminadoController@materialfactura");
        Route::get("/kardexproducto/productofactura", "Tb_kardex_producto_terminadoController@productofactura");
        Route::post("/kardexproducto/store", "Tb_kardex_producto_terminadoController@store");

        Route::get("/kardexalmacengeneral", "Tb_kardex_almacenController@general");
        Route::get("/kardexalmacen", "Tb_kardex_almacenController@index");
        Route::get("/kardexalmacen/listar", "Tb_kardex_almacenController@listar");
        Route::get("/kardexalmacenordenes", "Tb_kardex_almacenController@ordenes");
        Route::get("/kardexalmacen/material/{identificador}", "Tb_kardex_almacenController@material");
        Route::get("/kardexalmacen/preciomaterialorden", "Tb_kardex_almacenController@preciomaterialorden");
        Route::get("/kardexalmacen/preciomaterialcompra", "Tb_kardex_almacenController@preciomaterialcompra");
        Route::get("/kardexalmacen/factura", "Tb_kardex_almacenController@factura");
        Route::get("/kardexalmacen/materialfactura", "Tb_kardex_almacenController@materialfactura");
        Route::get("/kardexalmacen/productofactura", "Tb_kardex_almacenController@productofactura");
        Route::post("/kardexalmacen/store", "Tb_kardex_almacenController@store");

        Route::get("/kardexproducciongeneral", "Tb_kardex_produccionController@general");
        Route::get("/kardexproduccion", "Tb_kardex_produccionController@index");
        Route::get("/kardexproduccion/listar", "Tb_kardex_produccionController@listar");
        Route::post("/kardexproduccion/store", "Tb_kardex_produccionController@store");

        Route::get("/inventario", "Tb_inventarioController@index");
        Route::post("/inventario/validar", "Tb_inventarioController@validar");
    });

//---------------------------------------------------------------------------//

//accesos para los usuarios que son empresarios


    Route::group(['middleware' => ['Empresario']], function () {
        //accesos para los usuarios que son empresarios

        Route::get("/financiera", "Tb_informacion_financieraController@index");
        Route::put("/financiera/update", "Tb_informacion_financieraController@update");
        Route::post("/financiera/actualizar", "Tb_informacion_financieraController@actualizar");

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
        Route::get("/gestionmateria/selectGestionMateria", "Tb_gestion_materia_primaController@selectGestionMateria");

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

        Route::get("/manodeobraproducto", "Tb_mano_de_obra_productoController@index");
        Route::post("/manodeobraproducto/store", "Tb_mano_de_obra_productoController@store");
        Route::put("/manodeobraproducto/update", "Tb_mano_de_obra_productoController@update");
        Route::put("/manodeobraproducto/deactivate", "Tb_mano_de_obra_productoController@deactivate");
        Route::get("/manodeobraproducto/selectRelacionPerfil/{id}", "Tb_mano_de_obra_productoController@selectRelacionPerfil");
        Route::get("/manodeobraproducto/valorMinuto/{id}", "Tb_mano_de_obra_productoController@valorMinuto");

        Route::get("/materiaprimaproducto", "Tb_materia_prima_productoController@index");
        Route::post("/materiaprimaproducto/store", "Tb_materia_prima_productoController@store");
        Route::put("/materiaprimaproducto/update", "Tb_materia_prima_productoController@update");
        Route::put("/materiaprimaproducto/deactivate", "Tb_materia_prima_productoController@deactivate");
        Route::get("/materiaprimaproducto/selectMateriaPrimaProducto", "Tb_materia_prima_productoController@selectMateriaPrimaProducto");
        Route::get("/materiaprimaproducto/selectGestionMateria", "Tb_materia_prima_productoController@selectGestionMateria");
        Route::get("/materiaprimaproducto/valorPrecioBase/{id}", "Tb_materia_prima_productoController@valorPrecioBase");

        Route::get("/concepto", "Tb_concepto_cifController@index");
        Route::post("/concepto/store", "Tb_concepto_cifController@store");
        Route::put("/concepto/update", "Tb_concepto_cifController@update");
        Route::put("/concepto/deactivate", "Tb_concepto_cifController@deactivate");
        Route::put("/concepto/activate", "Tb_concepto_cifController@activate");
        Route::get("/concepto/selectConcepto", "Tb_concepto_cifController@selectConcepto");

        Route::get("/maquinaria", "Tb_maquinariaController@index");
        Route::post("/maquinaria/store", "Tb_maquinariaController@store");
        Route::put("/maquinaria/update", "Tb_maquinariaController@update");
        Route::put("/maquinaria/deactivate", "Tb_maquinariaController@deactivate");
        Route::put("/maquinaria/activate", "Tb_maquinariaController@activate");
        Route::get("/maquinaria/selectMaquinaria", "Tb_maquinariaController@selectMaquinaria");

        Route::get("/hojadecosto/total/{identificador}", "Hoja_De_CostosController@acumuladoTotal");
        Route::get("/hojadecosto/depreciacion/{identificador}", "Hoja_De_CostosController@maquinariaTotal");

    });

});
