<?php

namespace App\Http\Controllers;
use App\Tb_nomina;
use App\Tb_resumen_nomina;
use App\Tb_empleado;
use App\proceso;
use App\Perfil;
use App\Exports\DetalleNominaExport;
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
        'tb_resumen_nomina.totalDeducido','tb_resumen_nomina.totalPagar','tb_resumen_nomina.costoTotalMensual','tb_empleado.nombre as idEmpleado',
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
    public function export(){
        return Excel::download(new DetalleNominaExport, 'detalle_nomina.xlsx');
    }
}
