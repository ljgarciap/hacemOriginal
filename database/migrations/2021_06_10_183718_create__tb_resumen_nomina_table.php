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
            $table->date('fechaVinculacion');
            $table->integer('tipoContrato');
            $table->integer('diasLaborados');
            $table->integer('valordiasLaborados');
            $table->integer('extrasDiurnas');
            $table->integer('valorextrasDiurnas');
            $table->integer('extrasNocturnas');
            $table->integer('valorextrasNocturnas');
            $table->integer('horasDominicales');
            $table->integer('valorhorasDominicales');
            $table->integer('extrasDominicalesDiurnas');
            $table->integer('valorextrasDominicalesDiurnas');
            $table->integer('extrasDominicalesNocturnas');
            $table->integer('valorextrasDominicalesNocturnas');
            $table->integer('recargos');
            $table->integer('valorrecargos');
            $table->integer('totalhorasExtras');
            $table->integer('totalrecargos');
            $table->integer('totalExtrasyRecargos');
            $table->integer('primaExtralegal');
            $table->integer('bonificaciones');
            $table->integer('comisiones');
            $table->integer('viaticos');
            $table->integer('noFactorSalarial');
            $table->integer('devengadoSinAuxilio');
            $table->integer('auxilio');
            $table->integer('devengadoConAuxilio');
            $table->integer('ibcSalario');
            $table->integer('ibcConTope');
            $table->integer('descuentoSalud');
            $table->integer('descuentoPension');
            $table->integer('sindicato');
            $table->integer('prestamos');
            $table->integer('otros');
            $table->integer('totalDeducido');
            $table->integer('totalPagar');
            $table->integer('aporteSalud');
            $table->integer('aportePension');
            $table->integer('aporteArl');
            $table->integer('aporteSena');
            $table->integer('aporteCaja');
            $table->integer('cesantias');
            $table->integer('interesesCesantias');
            $table->integer('primaServicios');
            $table->integer('vacaciones');
            $table->integer('costoTotalMensual');
            $table->integer('sueldoBasicoMensual');
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
