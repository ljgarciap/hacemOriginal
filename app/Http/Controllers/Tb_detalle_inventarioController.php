<?php

namespace App\Http\Controllers;

use App\Tb_detalle_inventario;
use App\Tb_gestion_materia_prima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_detalle_inventarioController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $identificador= $request->id;
            # Modelo::join('tablaqueseune',basicamente un on)
            $productos = Tb_detalle_inventario::join('tb_gestion_materia_prima','tb_detalle_inventario.idProducto','=','tb_gestion_materia_prima.id')
            ->join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
            ->select('tb_detalle_inventario.id','tb_detalle_inventario.cantidad','tb_detalle_inventario.observacion',
            'tb_detalle_inventario.idProducto','tb_detalle_inventario.estado',
            'tb_gestion_materia_prima.gestionMateria','tb_unidad_base.unidadBase')
            ->where('tb_detalle_inventario.idInventario', '=', $identificador)->get();
            return ['productos' => $productos];
    }

    public function materias(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $identificador= $request->id;

        $materias = DB::table('tb_gestion_materia_prima')
        ->select('id as idProducto','producto')
        ->whereNotIn('id', DB::table('tb_detalle_inventario')->select('idProducto')->where('idInventario', '=', $identificador))
        ->get();

        return ['materias' => $materias];
    }

    public function listar(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;
        $identificador= $request->identificador;

        if ($buscar=='') {
            $productos = Tb_detalle_inventario::join('tb_gestion_materia_prima','tb_detalle_inventario.idProducto','=','tb_gestion_materia_prima.id')
            ->join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
            ->select('tb_detalle_inventario.id','tb_detalle_inventario.cantidad','tb_detalle_inventario.observacion',
            'tb_detalle_inventario.idProducto','tb_detalle_inventario.estado',
            'tb_gestion_materia_prima.gestionMateria','tb_unidad_base.unidadBase')
            ->where('tb_detalle_inventario.idInventario', '=', $identificador)
            ->orderBy('tb_detalle_inventario.id','desc')->paginate(5);
        }
        else if($criterio=='gestionMateria'){
            $productos = Tb_detalle_inventario::join('tb_gestion_materia_prima','tb_detalle_inventario.idProducto','=','tb_gestion_materia_prima.id')
            ->join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
            ->select('tb_detalle_inventario.id','tb_detalle_inventario.cantidad','tb_detalle_inventario.observacion',
            'tb_detalle_inventario.idProducto','tb_detalle_inventario.estado',
            'tb_gestion_materia_prima.gestionMateria','tb_unidad_base.unidadBase')
            ->where([
                ['tb_gestion_materia_prima.gestionMateria', 'like', '%'. $buscar . '%'],
                ['tb_detalle_inventario.idInventario', '=', $identificador],
            ])
            ->orderBy('tb_detalle_inventario.id','desc')->paginate(5);
        }
        else {
            # code...
            $productos = Tb_detalle_inventario::join('tb_gestion_materia_prima','tb_detalle_inventario.idProducto','=','tb_gestion_materia_prima.id')
            ->join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
            ->select('tb_detalle_inventario.id','tb_detalle_inventario.cantidad','tb_detalle_inventario.observacion',
            'tb_detalle_inventario.idProducto','tb_detalle_inventario.estado',
            'tb_gestion_materia_prima.gestionMateria','tb_unidad_base.unidadBase')
            ->where([
                ['tb_gestion_materia_prima.gestionMateria', 'like', '%'. $buscar . '%'],
                ['tb_detalle_inventario.idInventario', '=', $identificador],
            ])
            ->orderBy('tb_detalle_inventario.id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$productos->total(),
                'current_page'  =>$productos->currentPage(),
                'per_page'      =>$productos->perPage(),
                'last_page'     =>$productos->lastPage(),
                'from'          =>$productos->firstItem(),
                'to'            =>$productos->lastItem(),
            ],
                'productos' => $productos
        ];
    }

    public function store(Request $request)

        //if(!$request->ajax()) return redirect('/');
        $tb_detalle_inventario=new Tb_detalle_inventario();
        $tb_detalle_inventario->cantidad=$request->cantidad;
        $tb_detalle_cotizacion->observacion=$request->observacion;
        $tb_detalle_cotizacion->idProducto=$request->idProducto;
        $tb_detalle_cotizacion->idInventario=$request->idInventario;
        $tb_detalle_cotizacion->save();
    }
}
