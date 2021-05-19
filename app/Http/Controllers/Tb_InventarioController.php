<?php

namespace App\Http\Controllers;

use App\Tb_inventario;
use App\Tb_kardex_almacen;
use App\Tb_gestion_materia_prima;
use App\Tb_unidad_base;
use App\Tb_empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_inventarioController extends Controller
{
     //
     public function index(Request $request)
     {
         //if(!$request->ajax()) return redirect('/');
         $buscar= $request->buscar;
         $criterio= $request->criterio;
 
         if ($buscar=='') {
             # Modelo::join('tablaqueseune',basicamente un on)
             $inventarios = Tb_inventario::join('tb_empleado','tb_inventario.idEmpleado','=','tb_empleado.id')
             ->select('tb_inventario.id','tb_inventario.fecha','tb_inventario.idEmpleado','tb_inventario.estado',
             DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido," - ",tb_empleado.documento) as nombreEmpleado'))
             ->orderBy('tb_inventario.id','asc')->paginate(5);
         }
         else {
             $inventarios = Tb_inventario::join('tb_empleado','tb_inventario.idEmpleado','=','tb_empleado.id')
             ->select('tb_inventario.id','tb_inventario.fecha','tb_inventario.idEmpleado','tb_inventario.estado',
             DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido," - ",tb_empleado.documento) as nombreEmpleado'))
            ->where('tb_inventario.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_inventario.id','desc')->paginate(5);
         }
 
         return [
             'pagination' => [
                 'total'         =>$inventarios->total(),
                 'current_page'  =>$inventarios->currentPage(),
                 'per_page'      =>$inventarios->perPage(),
                 'last_page'     =>$inventarios->lastPage(),
                 'from'          =>$inventarios->firstItem(),
                 'to'            =>$inventarios->lastItem(),
             ],
                 'inventarios' => $inventarios
         ];
     }
     public function store(Request $request)
     {
         //if(!$request->ajax()) return redirect('/');
 
         $tb_inventario=new Tb_inventario();
         $tb_inventario->fecha=$request->fecha;
         $tb_inventario->idEmpleado=$request->idEmpleado;
         $tb_inventario->save();
     }
    public function empleados()
    {
        $empleados = Tb_empleado::select('tb_empleado.id','tb_empleado.nombre','tb_empleado.apellido',
        'tb_empleado.documento',
        DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido," - ",tb_empleado.documento) as nombreEmpleado'))
        ->get();
        return ['empleados' => $empleados];
    }
    public function estado(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        $idInventario= $request->id;
        $tb_inventario=Tb_inventario::findOrFail($request->id);
        $tb_inventario->estado=0;
        $tb_inventario->save();

    }

}

    /* $productos = Tb_kardex_almacen::join('tb_gestion_materia_prima','tb_kardex_almacen.idGestionMateria','=','tb_gestion_materia_prima.id')
        ->join('tb_unidad_base','tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id')
        ->select('tb_kardex_almacen.id','tb_kardex_almacen.cantidad','tb_kardex_almacen.precio',
        'tb_kardex_almacen.cantidadSaldos','tb_kardex_almacen.precioSaldos','tb_kardex_almacen.idGestionMateria',
        'tb_gestion_materia_prima.gestionMateria as producto','tb_gestion_materia_prima.estado',
        'tb_unidad_base.unidadBase','tb_unidad_base.estado',
        DB::raw('tb_kardex_almacen.cantidadSaldos * tb_kardex_almacen.precioSaldos as saldos'))
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
        ];*/
    