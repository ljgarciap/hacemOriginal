<?php

namespace App;

use App\Tb_resumen_nomina;
use App\Empleado;
use App\perfil;
use App\proceso;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetalleNominaExport implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        return [
            ' Id ',
            ' Empleado ',
            ' proceso ',
            ' perfil ',
            ' sueldoBasicoMensual ',
            ' devengadoConAuxilio ',
            ' totalDeducido ',
            ' totalPagar ',
            ' costoTotalMensual ',
        ];
    }
    public function collection()
    {
         $detalles = Tb_resumen_nomina::join('tb_empleado','tb_resumen_nomina.idEmpleado','=','tb_empleado.id')
         ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
         ->join('tb_proceso','tb_perfil.idProceso','=','tb_proceso.id')
         ->select('tb_resumen_nomina.id','tb_resumen_nomina.idEmpleado','tb_empleado.nombre as idEmpleado','tb_proceso.proceso',
         'tb_perfil.perfil','tb_resumen_nomina.sueldoBasicoMensual','tb_resumen_nomina.devengadoConAuxilio',
         'tb_resumen_nomina.totalDeducido','tb_resumen_nomina.totalPagar','tb_resumen_nomina.costoTotalMensual')->get();
         return $detalles;
    }
}