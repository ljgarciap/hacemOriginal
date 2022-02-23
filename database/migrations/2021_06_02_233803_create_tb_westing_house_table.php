<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbWestingHouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_westing_house', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idHabilidad')->constrained('tb_calificacion_habilidades');
            $table->foreignId('idEsfuerzo')->constrained('tb_calificacion_esfuerzo');
            $table->foreignId('idCondiciones')->constrained('tb_calificacion_condiciones');
            $table->foreignId('idConsistencia')->constrained('tb_calificacion_consistencia');
            $table->foreignId('idTiempoEstandar')->constrained('tb_tiempo_estandar');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_westing_house');
    }
}
