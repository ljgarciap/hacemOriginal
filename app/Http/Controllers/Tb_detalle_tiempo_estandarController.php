<?php

namespace App\Http\Controllers;

use App\Tb_tiempo_estandar;
use App\Tb_empleado;
use App\Tb_perfil;
use App\Tb_proceso;
use App\Tb_ciclos;
use App\Tb_westing_house;
use App\Tb_calificacion_habilidades;
use App\Tb_calificacion_esfuerzo;
use App\Tb_calificacion_condiciones;
use App\Tb_calificacion_consistencia;
use App\Tb_pds;
use App\Tb_esfuerzo_mental;
use App\Tb_esfuerzo_fisico;
use App\Tb_suplementarios;
use App\Tb_necesidades_personales;
use App\Tb_monotonia;
use App\Tb_Espera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_detalle_tiempo_estandarController extends Controller
{
    // Aca comienza la tabla de ciclos
    public function listarciclos(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $ciclos = Tb_ciclos::join('tb_tiempo_estandar','tb_ciclos.idTiempoEstandar','=','tb_tiempo_estandar.id')
        ->select('tb_ciclos.tiempo','tb_ciclos.piezas','tb.ciclos.idTiempoestandar')
        ->where('tb_ciclos.id','=',$id)
        ->orderBy('tb_ciclos.id','asc')
        ->paginate(5);

        return [
            'pagination' => [
                'total'         =>$ciclos->total(),
                'current_page'  =>$ciclos->currentPage(),
                'per_page'      =>$ciclos->perPage(),
                'last_page'     =>$ciclos->lastPage(),
                'from'          =>$ciclos->firstItem(),
                'to'            =>$ciclos->lastItem(),
            ],
            'ciclos' =>  $ciclos
        ];
    }
    public function guardarciclos(Request $request)
     {
         //if(!$request->ajax()) return redirect('/');
         $tb_ciclos=new Tb_ciclos();
         $tb_ciclos->tiempo=$request->tiempo;
         $tb_ciclos->piezas=$request->piezas;
         $tb_ciclos->idTiempoEstandar=1;
         $tb_ciclos->save();
     }
    // Aca termina la tabla de ciclos

    // Aca comienza la tabla de westing house
    public function listarwesting(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $westinghouse = Tb_westing_house::join('tb_tiempo_estandar','tb_westing_house.idTiempoEstandar','=','tb_tiempo_estandar.id')
        ->join('tb_calificacion_habilidades','tb_westing_house.idHabilidad','=','tb_calificacion_habilidades.id')
        ->join('tb_calificacion_esfuerzo','tb_westing_house.idEsfuerzo','=','tb_calificacion_esfuerzo.id')
        ->join('tb_calificacion_condiciones','tb_westing_house.idCondiciones','=','tb_calificacion_condiciones.id')
        ->join('tb_calificacion_consistencia','tb_westing_house.idConsistencia','=','tb_calificacion_consistencia.id')
        ->select('tb_westing_house.idHabilidad','tb_westing_house.idEsfuerzo','tb_westing_house.idCondiciones',
        'tb_westing_house.idConsistencia','tb_westing_house.idTiempoEstandar','tb_calificacion_habilidades.rango as idHabilidad','tb_calificacion_esfuerzo.rango as idEsfuerzo',
        'tb_calificacion_condiciones.rango as idCondiciones','tb_calificacion_consistencia.rango as idConsistencia')
        ->where('tb_westing_house.idTiempoEstandar','=',$id)
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

    public function guardarHabilidad(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_habilidades=new Tb_calificacion_habilidades();
        $tb_habilidades->rango=$request->rango;
        $tb_habilidades->porcentaje=$request->porcentaje;
        $tb_habilidades->clasificacion=$request->clasificacion;
        $tb_habilidades->save();

        $habilidades = Tb_westing_house::join('tb_calificacion_habilidades','tb_westing_house.idHabilidad','=','tb_calificacion_habilidades.id')
        ->select('tb_westing_house.idHabilidad','tb_calificacion_habilidades.id')
        ->orderBy('tb_westing_house.id','asc')
        ->whereIn('tb_westing_house.id', function($sub){$sub->selectRaw('max(id)')->from('tb_westing_house')->groupBy('idHabilidad');})
        ->get();
         foreach($habilidades as $h){
             $obj_habilidad= new Tb_westing_house();
             $obj_habilidad->idHabilidad=$tb_habilidades->id;
             $obj_habilidad->save();
         }
    }
    public function guardarEsfuerzo(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_habilidades=new Tb_calificacion_esfuerzo();
        $tb_habilidades->rango=$request->rango;
        $tb_habilidades->porcentaje=$request->porcentaje;
        $tb_habilidades->clasificacion=$request->clasificacion;
        $tb_habilidades->save();
    }
    public function guardarCondiciones(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_habilidades=new Tb_calificacion_condiciones();
        $tb_habilidades->rango=$request->rango;
        $tb_habilidades->porcentaje=$request->porcentaje;
        $tb_habilidades->clasificacion=$request->clasificacion;
        $tb_habilidades->save();
    }
    public function guardarConsistencia(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_habilidades=new Tb_calificacion_consistencia();
        $tb_habilidades->rango=$request->rango;
        $tb_habilidades->porcentaje=$request->porcentaje;
        $tb_habilidades->clasificacion=$request->clasificacion;
        $tb_habilidades->save();
    }
     // Aca termina la tabla de westing house

     // Aca comienza la tabla de pds
    public function listarpds(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
         $id=$request->id;
         $pds = Tb_pds::join('tb_tiempo_estandar','tb_pds.idTiempoEstandar','=','tb_pds.id')
        ->join('tb_esfuerzo_mental','tb_pds.idEsfuerzoMental','=','tb_esfuerzo_mental.id')
        ->join('tb_esfuerzo_fisico','tb_pds.idEsfuerzoFisico','=','tb_esfuerzo_fisico.id')
        ->join('tb_suplementarios','tb_pds.idSuplementario','=','tb_suplementarios.id')
        ->join('tb_necesidades_personales','tb_pds.idPersonales','=','tb_necesidades_personales.id')
        ->join('tb_monotonia','tb_pds.idMonotonia','=','tb_monotonia.id')
        ->join('tb_espera','tb_pds.idEspera','=','tb_espera.id')
        ->select('tb_pds.idEsfuerzoMental','tb_pds.idEsfuerzoFisico','tb_pds.idSuplementario',
        'tb_pds.idPersonales','tb_pds.idMonotonia','tb_pds.idEspera','tb_pds.idTiempoEstandar',
        'tb_esfuerzo_mental.grado as idEsfuerzoMental','tb_esfuerzo_fisico.grado as idEsfuerzoFisico',
        'tb_suplementarios.grado as idSuplementario','tb_necesidades_personales.rango as idPersonales',
        'tb_monotonia.clasificacion as idMonotonia','tb_espera.rangoMin as idEspera')
        ->where('tb_pds.idTiempoEstandar','=',$id)
        ->orderBy('tb_pds.id','asc')
        ->paginate(5);

        return [
            'pagination' => [
                'total'         =>$pds->total(),
                'current_page'  =>$pds->currentPage(),
                'per_page'      =>$pds->perPage(),
                'last_page'     =>$pds->lastPage(),
                'from'          =>$pds->firstItem(),
                'to'            =>$pds->lastItem(),
            ],
            'pds' =>  $pds
        ];
    }
    public function guardarEsfuerzoMental(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_esfuerzo_mental=new Tb_esfuerzo_mental();
        $tb_esfuerzo_mental->grado=$request->grado;
        $tb_esfuerzo_mental->porcentaje=$request->porcentaje;
        $tb_esfuerzo_mental->save();
    }
    public function guardarEsfuerzoFisico(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_esfuerzo_fisico=new Tb_esfuerzo_fisico();
        $tb_esfuerzo_fisico->grado=$request->grado;
        $tb_esfuerzo_fisico->porcentaje=$request->porcentaje;
        $tb_esfuerzo_fisico->save();
    }
    public function guardarSuplementarios(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_suplementarios=new Tb_suplementarios();
        $tb_suplementarios->grado=$request->grado;
        $tb_suplementarios->porcentaje=$request->porcentaje;
        $tb_suplementarios->save();
    }
    public function guardarPersonales(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_necesidades_personales=new Tb_necesidades_personales();
        $tb_necesidades_personales->rango=$request->rango;
        $tb_necesidades_personales->porcentajeHombre=$request->porcentajeHombre;
        $tb_necesidades_personales->porcentajeMujer=$request->porcentajeMujer;
        $tb_necesidades_personales->save();
    }

     // Aca termina la tabla de pds

     // Aca comienza la tabla de validar tiempo estandar
    public function listartiempo(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $tiempoestandar = Tb_tiempo_estandar::join('tb_empleado','tb_tiempo_estandar.idEmpleado','=','tb_empleado.id')
        ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
        ->join('tb_proceso','tb_perfil.idProceso','=','tb_proceso.id')
        ->select('tb_tiempo_estandar.tiempoNormal','tb_tiempo_estandar.factorPds','tb_tiempo_estandar.tiempoEstandar')
        ->where('tb_tiempo_estandar.id','=',$id)
        ->orderBy('tb_tiempo_estandar.id','asc')
        ->paginate(5);

        return [
            'pagination' => [
                'total'         =>$tiempoestandar->total(),
                'current_page'  =>$tiempoestandar->currentPage(),
                'per_page'      =>$tiempoestandar->perPage(),
                'last_page'     =>$tiempoestandar->lastPage(),
                'from'          =>$tiempoestandar->firstItem(),
                'to'            =>$tiempoestandar->lastItem(),
            ],
            'tiempoestandar' =>  $tiempoestandar
        ];
    }

    public function validar(Request $request){
        $tiempoEstandar=$request->data;
        $tiempoNormal=$request->tiempoNormal;
        $factorPds=$request->factorPds;
        $tiempos=Tb_tiempo_estandar::where('idTiempoEstandar','=',$tiempoEstandar[0])->get();
        foreach($tiempos as $t){
            $t->tiempoEstandar=$tiempoEstandar[$t->id];
            $t->tiempoEstandar=$t->tiempoNormal*$t->factorPds;
            $t->save();
        }
        $idTiempoEstandar=$request->id;
        $tb_tiempo_estandar=Tb_tiempo_estandar::findOrFail($request->id);
        $tb_tiempo_estandar->estado=0;
        $tb_tiempo_estandar->save();
        return ['tiempos'=>$tiempos];
    }
     // Aca termina la tabla de validar tiempo estandar

     // Aca comienza el detalle del tiempo estandar
    public function listardetalle(Request $request)
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
    // Aca termina el detalle del tiempo estandar
}
