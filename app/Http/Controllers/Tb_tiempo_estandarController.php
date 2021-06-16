<?php

namespace App\Http\Controllers;

use App\Tb_empleado;
use App\Tb_pds;
use App\Tb_perfil;
use App\Tb_proceso;
use App\Tb_tiempo_estandar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_tiempo_estandarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         //if(!$request->ajax()) return redirect('/');
         $buscar= $request->buscar;
         $criterio= $request->criterio;

         if ($buscar=='') {
             # Modelo::join('tablaqueseune',basicamente un on)
             $tiempoestandar = Tb_tiempo_estandar::join('tb_empleado','tb_tiempo_estandar.idEmpleado','=','tb_empleado.id')
             ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
             ->select('tb_tiempo_estandar.id','tb_tiempo_estandar.fecha','tb_tiempo_estandar.idEmpleado','tb_tiempo_estandar.estado',
             DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido," - ",tb_empleado.documento) as nombreEmpleado'))
             ->orderBy('tb_tiempo_estandar.id','desc')->paginate(5);
         }
         else {
            $tiempoestandar = Tb_tiempo_estandar::join('tb_empleado','tb_tiempo_estandar.idEmpleado','=','tb_empleado.id')
             ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
             ->select('tb_tiempo_estandar.id','tb_tiempo_estandar.fecha','tb_tiempo_estandar.idEmpleado','tb_tiempo_estandar.estado',
             DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido," - ",tb_empleado.documento) as nombreEmpleado'))
            ->where('tb_tiempo_estandar.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_tiempo_estandar.id','desc')->paginate(5);
         }
         /*
         ,'tb_tiempo_estandar.tiempoElemental',
             'tb_tiempo_estandar.tiempoNormal','tb_tiempo_estandar.factorPds','tb_tiempo_estandar.tiempoEstandar','tb_tiempo_estandar.numeroPiezas',
             'tb_tiempo_estandar.piezasPar','tb_tiempo_estandar.tiempoPiezas','tb_tiempo_estandar.factorValoracion',
         */
         return [
             'pagination' => [
                 'total'         =>$tiempoestandar->total(),
                 'current_page'  =>$tiempoestandar->currentPage(),
                 'per_page'      =>$tiempoestandar->perPage(),
                 'last_page'     =>$tiempoestandar->lastPage(),
                 'from'          =>$tiempoestandar->firstItem(),
                 'to'            =>$tiempoestandar->lastItem(),
             ],
                 'tiempoestandar' => $tiempoestandar
         ];
     }

     public function store(Request $request)
     {
         //if(!$request->ajax()) return redirect('/');

         $tb_tiempo_estandar=new Tb_tiempo_estandar();
         $tb_tiempo_estandar->fecha=$request->fecha;
         $tb_tiempo_estandar->idEmpleado=$request->idEmpleado;
         $tb_tiempo_estandar->tiempoElemental=0;
         $tb_tiempo_estandar->tiempoNormal=0;
         $tb_tiempo_estandar->factorPds=0;
         $tb_tiempo_estandar->tiempoEstandar=0;
         $tb_tiempo_estandar->numeroPiezas=$request->numeroPiezas;
         $tb_tiempo_estandar->piezasPar=$request->piezasPar;
         $tb_tiempo_estandar->tiempoPiezas=0;
         $tb_tiempo_estandar->factorValoracion=0;
         $tb_tiempo_estandar->estado=1;
         $tb_tiempo_estandar->save();

    
         
     }
     public function empleados()
    {
        $empleados = Tb_empleado::select('tb_empleado.id','tb_empleado.nombre','tb_empleado.apellido',
        'tb_empleado.documento',
        DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido," - ",tb_empleado.documento) as nombreEmpleado'))
        ->get();
        return ['empleados' => $empleados];
    }
}
