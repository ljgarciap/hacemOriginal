<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCiclosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_ciclos', function (Blueprint $table) {
            $table->id();
            $table->integer('tiempo');
            $table->integer('piezas');
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
        Schema::dropIfExists('tb_ciclos');
    }
}
