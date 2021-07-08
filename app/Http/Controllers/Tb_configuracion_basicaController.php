<?php


namespace App\Http\Controllers;

use App\Tb_tipo_nomina;
use App\Tb_administradora_pensiones;
use App\Tb_eps;
use App\Tb_configuracion_basica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_configuracion_basicaController extends Controller
{
    //
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $configuracion = Tb_configuracion_basica::where('id','=',1)
        ->select('id','nombre','direccion','telefono','cajaCompensacion','arl','nivelRiesgo','idTipoNomina')->get();

        foreach($configuracion as $c){
            $nombre = $c->nombre;
            $direccion = $c->direccion;
            $telefono = $c->telefono;
            $cajaCompensacion = $c->cajaCompensacion;
            $arl = $c->arl;
            $nivelRiesgo = $c->nivelRiesgo;
            $idTipoNomina = $c->idTipoNomina;
        }

        return ['nombre' => $nombre,
        'direccion' => $direccion,
        'telefono' => $telefono,
        'cajaCompensacion' => $cajaCompensacion,
        'arl' => $arl,
        'nivelRiesgo' => $nivelRiesgo,
        'idTipoNomina' => $idTipoNomina
        ];
    }
    
    public function CajaCompensacion()
    {
        $cajacompensacion = Tb_Eps::select('tb_eps.id','tb_eps.nombreEps',
        DB::raw('(tb_eps.nombreEps) as NombreCajaCompensacion'))
        ->get();

        return ['cajacompensacion' => $cajacompensacion];
    }

    public function Arl()
    {
        $arl = Tb_administradora_pensiones::select('tb_administradora_pensiones.id','tb_administradora_pensiones.nombrePensiones',
        DB::raw('(tb_administradora_pensiones.nombrePensiones) as nombreArl'))
        ->get();

        return ['arl' => $arl];
    }

    public function tipoNomina()
    {
        $tiponomina = Tb_tipo_nomina::select('tb_tipo_nomina.id','tb_tipo_nomina.periodicidad','tb_tipo_nomina.dias',
        DB::raw('(tb_tipo_nomina.periodicidad) as tipoNomina'))
        ->get();

        return ['tiponomina' => $tiponomina];
    }
    public function store(Request $request)
    {
        $tb_configuracion_basica= new Tb_configuracion_basica();
        $tb_configuracion_basica->nombre=$request->nombre;
        $tb_configuracion_basica->direccion=$request->direccion;
        $tb_configuracion_basica->telefono=$request->telefono;
        $tb_configuracion_basica->cajaCompensacion=$request->cajaCompensacion;
        $tb_configuracion_basica->arl=$request->arl;
        $tb_configuracion_basica->nivelRiesgo=$request->nivelRiesgo;
        $tb_configuracion_basica->idTipoNomina=$request->idTipoNomina;
        $tb_configuracion_basica->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_configuracion_basica=Tb_configuracion_basica::findOrFail($request->id);
        $tb_configuracion_basica->nombre=$request->nombre;
        $tb_configuracion_basica->direccion=$request->direccion;
        $tb_configuracion_basica->telefono=$request->telefono;
        $tb_configuracion_basica->cajaCompensacion=$request->cajaCompensacion;
        $tb_configuracion_basica->arl=$request->arl;
        $tb_configuracion_basica->nivelRiesgo=$request->nivelRiesgo;
        $tb_configuracion_basica->idTipoNomina=$request->idTipoNomina;
        $tb_configuracion_basica->save();
    }
    public function actualizar(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_configuracion_basica=Tb_configuracion_basica::findOrFail($request->id);
        $tb_configuracion_basica=Tb_configuracion_basica::findOrFail($request->id);
        $tb_configuracion_basica->nombre=$request->nombre;
        $tb_configuracion_basica->direccion=$request->direccion;
        $tb_configuracion_basica->telefono=$request->telefono;
        $tb_configuracion_basica->cajaCompensacion=$request->cajaCompensacion;
        $tb_configuracion_basica->arl=$request->arl;
        $tb_configuracion_basica->nivelRiesgo=$request->nivelRiesgo;
        $tb_configuracion_basica->idTipoNomina=$request->idTipoNomina;
        $tb_configuracion_basica->save();
    }
}
