<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idEsfuerzoMental')->constrained('tb_esfuerzo_mental');
            $table->foreignId('idEsfuerzoFisico')->constrained('tb_esfuerzo_fisico');
            $table->foreignId('idSuplementario')->constrained('tb_suplementarios');
            $table->foreignId('idPersonales')->constrained('tb_necesidades_personales');
            $table->foreignId('idMonotonia')->constrained('tb_monotonia');
            $table->foreignId('idEspera')->constrained('tb_espera')->nullable();
            $table->integer('valorEspera');
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
        Schema::dropIfExists('tb_pds');
    }
}
