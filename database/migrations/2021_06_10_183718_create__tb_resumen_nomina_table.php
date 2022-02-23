<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbResumenNominaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_resumen_nomina', function (Blueprint $table) {
            $table->id();
            $table->date('fechaVinculacion')->nullable();
            $table->integer('tipoContrato')->nullable();
            $table->integer('diasLaborados')->nullable();
            $table->integer('valordiasLaborados')->nullable();
            $table->integer('extrasDiurnas')->nullable();
            $table->integer('valorextrasDiurnas')->nullable();
            $table->integer('extrasNocturnas')->nullable();
            $table->integer('valorextrasNocturnas')->nullable();
            $table->integer('horasDominicales')->nullable();
            $table->integer('valorhorasDominicales')->nullable();
            $table->integer('extrasDominicalesDiurnas')->nullable();
            $table->integer('valorextrasDominicalesDiurnas')->nullable();
            $table->integer('extrasDominicalesNocturnas')->nullable();
            $table->integer('valorextrasDominicalesNocturnas')->nullable();
            $table->integer('recargos')->nullable();
            $table->integer('valorrecargos')->nullable();
            $table->integer('totalhorasExtras')->nullable();
            $table->integer('totalrecargos')->nullable();
            $table->integer('totalExtrasyRecargos')->nullable();
            $table->integer('primaExtralegal')->nullable();
            $table->integer('bonificaciones')->nullable();
            $table->integer('comisiones')->nullable();
            $table->integer('viaticos')->nullable();
            $table->integer('noFactorSalarial')->nullable();
            $table->integer('devengadoSinAuxilio')->nullable();
            $table->integer('auxilio')->nullable();
            $table->integer('devengadoConAuxilio')->nullable();
            $table->integer('ibcSalario')->nullable();
            $table->integer('ibcConTope')->nullable();
            $table->integer('descuentoSalud')->nullable();
            $table->integer('descuentoPension')->nullable();
            $table->integer('fondoSolidaridad')->nullable();
            $table->integer('retencion')->nullable();
            $table->integer('sindicato')->nullable();
            $table->integer('prestamos')->nullable();
            $table->integer('otros')->nullable();
            $table->integer('totalDeducido')->nullable();
            $table->integer('totalPagar')->nullable();
            $table->integer('aporteSalud')->nullable();
            $table->integer('aportePension')->nullable();
            $table->integer('aporteArl')->nullable();
            $table->integer('aporteIcbf')->nullable();
            $table->integer('aporteSena')->nullable();
            $table->integer('aporteCaja')->nullable();
            $table->integer('cesantias')->nullable();
            $table->integer('interesesCesantias')->nullable();
            $table->integer('primaServicios')->nullable();
            $table->integer('vacaciones')->nullable();
            $table->integer('costoTotalMensual')->nullable();
            $table->integer('sueldoBasicoMensual')->nullable();
            $table->foreignId('idEmpleado')->constrained('tb_empleado');
            $table->foreignId('idNomina')->constrained('tb_nomina');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_resumen_nomina');
    }
}
