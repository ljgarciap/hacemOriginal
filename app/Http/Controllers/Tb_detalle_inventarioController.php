<?php

namespace App\Http\Controllers;

use App\Tb_detalle_inventario;
use App\Tb_kardex_almacen;
use App\Tb_gestion_materia_prima;
use App\Tb_unidad_base;
use App\Tb_almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_detalle_inventarioController extends Controller
{
    //
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $identificador= $request->id;
            # Modelo::join('tablaqueseune',basicamente un on)
            $detalles = Tb_detalle_inventario::join('tb_gestion_materia_prima','tb_detalle_inventario.idProducto','=','tb_gestion_materia_prima.id')
            ->join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
            ->select('tb_detalle_inventario.id','tb_detalle_inventario.idProducto','tb_detalle_inventario.unidadBase','tb_detalle_inventario.cantidadSistema',
            'tb_detalle_inventario.cantidadActual','tb_detalle_inventario.observacion','tb_detalle_inventario.idInventario',
            'tb_gestion_materia_prima.gestionMateria','tb_unidad_base.unidadBase')
            ->where('tb_detalle_inventario.idInventario', '=', $identificador)->get();

            return ['detalles' => $detalles];
    }


    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_detalle_inventario=new Tb_detalle_inventario();
        $tb_detalle_inventario->idProducto=$request->idProducto;
        $tb_detalle_inventario->unidadBase=$request->unidadBase;
        $tb_detalle_inventario->cantidadSistema=$request->cantidadSistema;
        $tb_detalle_inventario->cantidadActual=$request->cantidadActual;
        $tb_detalle_inventario->observacion=$request->observacion;
        $tb_detalle_inventario->idInventario=$request->idInventario;
        $tb_detalle_inventario->save();

    }

    public function validar(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        $cantidadActual=$request->cantidadActual;
        $cantidadSistema=$request->cantidadSistema;
        $idProducto=0;

        $validarCantidad = DB::table('tb_kardex_almacen')
        ->select('id','cantidad','cantidadSaldos as cantidadS','precioSaldos as precioS')
        ->where('tb_kardex_almacen.idGestionMateria','=', $idProducto)
        ->orderByDesc('id')
        ->limit(1)
        ->get();
    }

    public function listar()
    {
        //if(!$request->ajax()) return redirect('/');

        $productos = Tb_kardex_almacen::join('tb_gestion_materia_prima','tb_kardex_almacen.idGestionMateria','=','tb_gestion_materia_prima.id')
        ->join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
        ->select('tb_kardex_almacen.idGestionMateria as id','tb_kardex_almacen.cantidadSaldos','tb_gestion_materia_prima.gestionMateria as producto',
        'tb_unidad_base.unidadBase')
        ->orderBy('tb_kardex_almacen.idGestionMateria','asc')
        ->whereIn('tb_kardex_almacen.id', function($sub){$sub->selectRaw('max(id)')->from('tb_kardex_almacen')->groupBy('idGestionMateria');})
        ->paginate(5);

        return [
            'pagination' => [
                'total'         =>$productos->total(),
                'current_page'  =>$productos->currentPage(),
                'per_page'      =>$productos->perPage(),
                'last_page'     =>$productos->lastPage(),
                'from'          =>$productos->firstItem(),
                'to'            =>$productos->lastItem(),
            ],
            'productos' =>  $productos
        ];
    }
}
