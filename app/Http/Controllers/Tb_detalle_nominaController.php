<?php

namespace App\Http\Controllers;
use App\Tb_nomina;
use App\Tb_resumen_nomina;
use App\Tb_empleado;
use App\Tb_proceso;
use App\Tb_Perfil;
use App\Exports\DetalleNominaFija;
use App\Exports\DetalleNominaDestajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class Tb_detalle_nominaController extends Controller
{
    public function listardetalle(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $detalles = Tb_resumen_nomina::join('tb_empleado','tb_resumen_nomina.idEmpleado','=','tb_empleado.id')
        ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
        ->join('tb_proceso','tb_perfil.idProceso','=','tb_proceso.id')
        ->select('tb_resumen_nomina.sueldoBasicoMensual','tb_resumen_nomina.idEmpleado','tb_resumen_nomina.devengadoConAuxilio',
        'tb_resumen_nomina.totalDeducido','tb_resumen_nomina.totalPagar','tb_resumen_nomina.costoTotalMensual',
        DB::raw("CONCAT(tb_empleado.nombre,' ',tb_empleado.apellido) as nombreEmpleado"),'tb_resumen_nomina.idNomina',
        'tb_perfil.perfil','tb_proceso.proceso')
        ->where('tb_resumen_nomina.idNomina','=',$id)
        ->orderBy('tb_resumen_nomina.idEmpleado','asc')
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
    public function export($idNomina){
        $nominaid=$idNomina;
        $tb_nomina=Tb_nomina::findOrFail($nominaid);
        $flag=$tb_nomina->tipo;
        if ($flag==1){
            return (new DetalleNominaFija($idNomina))->download('Nomina_Fija_'.date('Y-m-d_H_i_s').'.xlsx');
            }
        else{
            return (new DetalleNominaDestajo($idNomina))->download('Nomina_Destajo_'.date('Y-m-d_H_i_s').'.xlsx');
        }
    }
    public function detalles(Request $request){
        $idEmpleado=$request->idEmpleado;
        $idNomina=$request->idNomina;

        $detalles = Tb_resumen_nomina::join('tb_empleado','tb_resumen_nomina.idEmpleado','=','tb_empleado.id')
        ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
        ->join("tb_vinculaciones","tb_empleado.id","=","tb_vinculaciones.idEmpleado")
        ->join("tb_niveles_riesgo","tb_vinculaciones.idNivelArl",'=',"tb_niveles_riesgo.id")
        ->select('tb_resumen_nomina.id','tb_empleado.documento','tb_perfil.perfil','tb_niveles_riesgo.nivelArl',
        'tb_niveles_riesgo.porcentajeNivelArl','tb_resumen_nomina.fechaVinculacion','tb_resumen_nomina.tipoContrato','tb_resumen_nomina.sueldoBasicoMensual',
        'tb_resumen_nomina.diasLaborados','tb_resumen_nomina.valorDiasLaborados','tb_resumen_nomina.extrasDiurnas','tb_resumen_nomina.valorextrasDiurnas',
        'tb_resumen_nomina.extrasNocturnas','tb_resumen_nomina.valorextrasNocturnas','tb_resumen_nomina.horasDominicales',
        'tb_resumen_nomina.valorhorasDominicales','tb_resumen_nomina.extrasDominicalesDiurnas','tb_resumen_nomina.valorextrasDominicalesDiurnas',
        'tb_resumen_nomina.extrasDominicalesNocturnas','tb_resumen_nomina.valorextrasDominicalesNocturnas','tb_resumen_nomina.recargos',
        'tb_resumen_nomina.valorrecargos','tb_resumen_nomina.totalhorasExtras','tb_resumen_nomina.totalrecargos',
        'tb_resumen_nomina.totalExtrasyRecargos','tb_resumen_nomina.primaExtralegal','tb_resumen_nomina.bonificaciones','tb_resumen_nomina.comisiones',
        'tb_resumen_nomina.viaticos','tb_resumen_nomina.noFactorSalarial','tb_resumen_nomina.devengadoSinAuxilio','tb_resumen_nomina.auxilio',
        'tb_resumen_nomina.devengadoConAuxilio','tb_resumen_nomina.ibcSalario','tb_resumen_nomina.ibcConTope','tb_resumen_nomina.descuentoSalud',
        'tb_resumen_nomina.descuentoPension','tb_resumen_nomina.fondoSolidaridad','tb_resumen_nomina.retencion','tb_resumen_nomina.sindicato',
        'tb_resumen_nomina.prestamos','tb_resumen_nomina.otros','tb_resumen_nomina.totalDeducido','tb_resumen_nomina.totalPagar',
        'tb_resumen_nomina.aporteSalud','tb_resumen_nomina.aportePension','tb_resumen_nomina.aporteArl','tb_resumen_nomina.aporteSena',
        'tb_resumen_nomina.aporteIcbf','tb_resumen_nomina.aporteCaja','tb_resumen_nomina.cesantias','tb_resumen_nomina.interesesCesantias',
        'tb_resumen_nomina.primaServicios','tb_resumen_nomina.vacaciones','tb_resumen_nomina.costoTotalMensual',
        DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido) as nombreEmpleado'))
        ->where('tb_resumen_nomina.idEmpleado','=',$idEmpleado)
        ->where('tb_resumen_nomina.idNomina','=',$idNomina)
        ->orderBy('id','asc')
        ->get();
        return [
            'detalles' =>  $detalles
        ];
    }
}
