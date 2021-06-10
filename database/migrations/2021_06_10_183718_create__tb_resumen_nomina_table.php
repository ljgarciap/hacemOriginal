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
            $table->float('sueldoBasicoMensual',10,2);
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
