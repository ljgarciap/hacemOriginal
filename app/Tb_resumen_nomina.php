<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_resumen_nomina extends Model
{
    //
    protected $table = 'tb_resumen_nomina';

    protected $fillable = [
        'fechaVinculacion','tipoContrato','diasLaborados','valordiasLaborados','extrasDiurnas',
        'valorextrasDiurnas','extrasNocturnas','valorextrasNocturnas','horasDominicales',
        'valorhorasDominicales','extrasDominicalesDiurnas','valorextrasDominicalesDiurnas',
        'extrasDominicalesNocturnas','valorextrasDominicalesNocturnas','extrasDominicalesNocturnas',
        'valorextrasDominicalesNocturnas','recargos','valorrecargos','totalhorasExtras','totalrecargos',
        'totalExtrasyRecargos','primaExtralegal','bonificaciones','comisiones','viaticos',
        'noFactorSalarial','devengadoSinAuxilio','auxilio','devengadoConAuxilio','ibcSalario',
        'ibcConTope','descuentoSalud','descuentoPension','fondoSolidaridad','retencion','sindicato','prestamos','otros',
        'totalDeducido','totalPagar','aporteSalud','aportePension','aporteArl','aporteIcbf','aporteSena',
        'aporteCaja','cesantias','interesesCesantias','primaServicios','vacaciones',
        'costoTotalMensual','sueldoBasicoMensual','idEmpleado','idNomina'
    ];

    public $timestamps = false;
}
