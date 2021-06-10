<?php

namespace App\Http\Controllers;

use App\Tb_empleado;
use App\Tb_pds;
use App\Tb_perfil;
use App\Tb_proceso;
use App\Tb_westing_house;
use App\Tb_calificacion_habilidades;
use App\Tb_calificacion_esfuerzo;
use App\Tb_calificacion_condiciones;
use App\Tb_calificacion_consistencia;
use App\Tb_ciclos;
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
             ->select('tb_tiempo_estandar.id','tb_tiempo_estandar.fecha','tb_tiempo_estandar.idEmpleado',
             DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido," - ",tb_empleado.documento) as nombreEmpleado'))
             ->orderBy('tb_tiempo_estandar.id','desc')->paginate(5);
         }
         else {
            $tiempoestandar = Tb_tiempo_estandar::join('tb_empleado','tb_tiempo_estandar.idEmpleado','=','tb_empleado.id')
             ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
             ->select('tb_tiempo_estandar.id','tb_tiempo_estandar.fecha','tb_tiempo_estandar.idEmpleado',
             DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido," - ",tb_empleado.documento) as nombreEmpleado'))
            ->where('tb_tiempo_estandar.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_tiempo_estandar.id','dec')->paginate(5);
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
         $tb_tiempo_estandar->numeroPiezas=0;
         $tb_tiempo_estandar->piezasPar=0;
         $tb_tiempo_estandar->tiempoPiezas=0;
         $tb_tiempo_estandar->factorValoracion=0;
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
    
    public function listar(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $westinghouse = Tb_westing_house::join('tb_tiempo_estandar','tb_westing_house.idTiempoEstandar','=','tb_westing_house.id')
        ->join('tb_calificacion_habilidades','tb_westing_house.idHabilidad','=','tb_calificacion_habilidades.id')
        ->join('tb_calificacion_esfuerzo','tb_westing_house.idEsfuerzo','=','tb_calificacion_esfuerzo.id')
        ->join('tb_calificacion_condiciones','tb_westing_house.idCondiciones','=','tb_calificacion_condiciones.id')
        ->join('tb_calificacion_consistencia','tb_westing_house.idConsistencia','=','tb_calificacion_consistencia.id')
        ->select('tb_westing_house.idHabilidad','tb_westing_house.idEsfuerzo','tb_westing_house.idCondiciones',
        'tb_westing_house.idConsistencia','tb_westing_house.idTiempoEstandar','tb_calificacion_habilidades.rango as idHabilidad','tb_calificacion_esfuerzo.rango as idEsfuerzo',
        'tb_calificacion_condiciones.rango as idCondiciones','tb_calificacion_consistencia.rango as idConsistencia')
        ->where('tb_westing_house.id','=',$id)
        ->orderBy('tb_westing_house.id','asc')
        ->paginate(5);

        return [
            'pagination' => [
                'total'         =>$westinghouse->total(),
                'current_page'  =>$westinghouse->currentPage(),
                'per_page'      =>$westinghouse->perPage(),
                'last_page'     =>$westinghouse->lastPage(),
                'from'          =>$westinghouse->firstItem(),
                'to'            =>$westinghouse->lastItem(),
            ],
            'westinghouse' =>  $westinghouse
        ];
    }

    public function listar3(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $detalles = Tb_tiempo_estandar::join('tb_empleado','tb_tiempo_estandar.idEmpleado','=','tb_empleado.id')
        ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
        ->join('tb_proceso','tb_perfil.idProceso','=','tb_proceso.id')
        ->select('tb_tiempo_estandar.fecha','tb_tiempo_estandar.idEmpleado','tb_tiempo_estandar.tiempoElemental',
        'tb_tiempo_estandar.tiempoNormal','tb_tiempo_estandar.factorPds','tb_tiempo_estandar.tiempoEstandar','tb_tiempo_estandar.numeroPiezas',
        'tb_tiempo_estandar.piezasPar','tb_tiempo_estandar.tiempoPiezas','tb_tiempo_estandar.factorValoracion','tb_empleado.nombre as idEmpleado',
        'tb_empleado.genero','tb_perfil.perfil','tb_proceso.proceso')
        ->where('tb_tiempo_estandar.id','=',$id)
        ->orderBy('tb_tiempo_estandar.idEmpleado','asc')
        ->paginate(5);

        return [
            'pagination' => [
                'total'         =>$detalles->total(),
                'current_page'  =>$detalles->currentPage(),
                'per_page'      =>$detalles->perPage(),
                'last_page'     =>$detalles->lastPage(),
                'from'          =>$detalles->firstItem(),
                'to'            =>$detalles->lastItem(),
            ],
            'detalles' =>  $detalles
        ];
    }

}
