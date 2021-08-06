<?php

namespace App\Http\Controllers;
use App\Tb_nomina;
use App\Tb_vinculaciones;
use App\Tb_novedades;
use App\Tb_resumen_nomina;
use App\Tb_niveles_riesgo;
use App\Tb_factores_nomina;
use App\Jobs\CalcularNomina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_nominaController extends Controller
{
    //
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            # Modelo::join('tablaqueseune',basicamente un on)
            $nomina = Tb_nomina::select('tb_nomina.id','tb_nomina.fechaInicio as fecha','tb_nomina.fechaFin','tb_nomina.tipo','tb_nomina.observacion','tb_nomina.estado')
            ->orderBy('tb_nomina.id','desc')->paginate(5);
        }
        else {
            # code...
            $nomina = Tb_nomina::select('tb_nomina.id','tb_nomina.fechaInicio as fecha','tb_nomina.fechaFin','tb_nomina.tipo','tb_nomina.observacion','tb_nomina.estado')
            ->where('tb_nomina.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_nomina.id','desc')->paginate(5);

        }

        return [
            'pagination' => [
                'total'         =>$nomina->total(),
                'current_page'  =>$nomina->currentPage(),
                'per_page'      =>$nomina->perPage(),
                'last_page'     =>$nomina->lastPage(),
                'from'          =>$nomina->firstItem(),
                'to'            =>$nomina->lastItem(),
            ],
                'nomina' => $nomina
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_nomina=new Tb_nomina();
        $tb_nomina->fechaInicio=$request->fechaInicio;
        $tb_nomina->fechaFin=$request->fechaFin;
        $tb_nomina->tipo=$request->tipo;
        $tb_nomina->observacion=$request->observacion;
        $tb_nomina->estado=1;
        //$tb_nomina->fechaFin=$request->fechaFin;
        $tb_nomina->save();
    }

    /*public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_nomina=Tb_nomina::findOrFail($request->id);
        //$tb_nomina->fechaInicio=$request->fechaInicio;
        $tb_nomina->fechaFIn=$request->fechaFin;
        $tb_nomina->estado=1;
        $tb_nomina->save();
    }*/
    public function delete(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        // busco el padre
        $tb_nomina=Tb_nomina::find($request->id);
        // busco el hijo y lo borro
        if($tb_nomina){
        $tb_novedades=Tb_novedades::where('idNomina',$request->id);
        if($tb_novedades){
        $tb_novedades->idNomina=$request->idNomina;
        $tb_novedades->delete();
        }
        // borro el padre
        $tb_nomina->delete();
        }
        //return ['nomina' => $nomina];
    }
    public function estado(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_nomina=Tb_nomina::findOrFail($request->id);
        $tb_nomina->estado=0;
        $tb_nomina->save();
    }

//---------------------------------------------------------------------------------------------------//
// Cálculo de nómina fija
//---------------------------------------------------------------------------------------------------//

    public function calcularNomina(Request $request)
    { 
        if(!$request->ajax()) return redirect('/');
        $nominaid=$request->id;
        CalcularNomina::dispatch($nominaid);
    } //cierre función cálculo

//---------------------------------------------------------------------------------------------------//
// Cálculo de nómina
//---------------------------------------------------------------------------------------------------//

    public function prueba(Request $request)
    {
        $signal=$request->id;

        $empleadonovedades = Tb_novedades::where('idNomina','=',$signal)->groupby('idEmpleado')->distinct()->select('idEmpleado')->get();

         //dentro de este foreach voy a sacar los datos de los empleados que hacen parte de la nómina para buscar sus novedades
        foreach($empleadonovedades as $empleadonovedad){ //abre foreach vinculaciones

            $empleadonovedadid = $empleadonovedad->idEmpleado;

            }

            return [
                    'empleadonovedades' => $empleadonovedades
            ];
    }

}
