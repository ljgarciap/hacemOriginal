<?php

namespace App\Http\Controllers;

use App\Tb_detalle_inventario;
use App\Tb_kardex_almacen;
use App\Tb_gestion_materia_prima;
use App\Tb_unidad_base;
use App\Tb_almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            'tb_detalle_inventario.cantidadActual','tb_detalle_inventario.diferencia','tb_detalle_inventario.observacion','tb_detalle_inventario.idInventario',
            'tb_gestion_materia_prima.gestionMateria as producto','tb_unidad_base.unidadBase')
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

    public function verificar(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $respuesta=$request;

        return ['respuesta' => $respuesta];

    }

    public function validar(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
      
        $cantidadActual=$request->cantidadActual;
        $cantidadSistema=$request->cantidadSistema;
        $diferencia=$request->diferencia;
        $idProducto=0;

        $validarCantidad = DB::table('tb_kardex_almacen')
        ->select('id','cantidad','cantidadSaldos as cantidadS','precioSaldos as precioS')
        ->where('tb_kardex_almacen.idGestionMateria','=', $idProducto)
        ->orderByDesc('id')
        ->limit(1)
        ->get();
         
    }
    public function verificar1(Request $request){
        $cantidad=$request->data;
        //\Log::debug($cantidad[0]);
        $inventario=Tb_detalle_inventario::where('idInventario','=',$cantidad[0])->get();
        foreach($inventario as $i){
            $i->cantidadActual=$cantidad[$i->id];
            $i->diferencia=$i->cantidadActual-$i->cantidadSistema;
            //\Log::debug($i);
            $i->save();
        }
        $inventario=Tb_detalle_inventario::where('diferencia','!=',0)->where('idInventario','=',$cantidad[0])->get();
        //$cantidadActual=$request->cantidadActual;
        //$output = new Symfony\Component\Console\Output\ConsoleOutput();
        //$output->writeln("<info>error</info>");
        //\Log::debug($cantidad);
        return ['inventario'=>$inventario];  
    }
     
    public function observacion(Request $request){
        $observacion=$request->data;
        $inventario=Tb_detalle_inventario::where('idInventario','=',$observacion[0])->get();
        foreach($inventario as $i){
            $i->observacion=$observacion[$i->id];
            $i->save();
        }
    }

    public function listar(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $productos = Tb_detalle_inventario::join('tb_gestion_materia_prima','tb_detalle_inventario.idProducto','=','tb_gestion_materia_prima.id')
        ->join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
        ->select('tb_detalle_inventario.id','tb_detalle_inventario.idProducto','tb_detalle_inventario.cantidadSistema',
        'tb_gestion_materia_prima.gestionMateria as producto','tb_unidad_base.unidadBase')
        ->where('tb_detalle_inventario.idInventario','=',$id)
        ->orderBy('tb_detalle_inventario.idProducto','asc')
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
    public function listar2(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $productos = Tb_detalle_inventario::join('tb_gestion_materia_prima','tb_detalle_inventario.idProducto','=','tb_gestion_materia_prima.id')
        ->join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
        ->select('tb_detalle_inventario.id','tb_detalle_inventario.idProducto','tb_detalle_inventario.cantidadSistema','tb_detalle_inventario.diferencia',
        'tb_gestion_materia_prima.gestionMateria as producto','tb_unidad_base.unidadBase')
        ->where('tb_detalle_inventario.idInventario','=',$id)
        ->orderBy('tb_detalle_inventario.idProducto','asc')
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
