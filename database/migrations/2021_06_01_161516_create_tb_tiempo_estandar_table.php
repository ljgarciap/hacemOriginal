<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTiempoEstandarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_tiempo_estandar', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->format('Y.m.d');
            $table->foreignId('idEmpleado')->constrained('tb_empleado');
            $table->integer('tiempoElemental');
            $table->float('tiempoNormal',8, 2);
            $table->float('factorPds',8, 2);
            $table->float('tiempoEstandar',8, 2);
            $table->integer('numeroPiezas');
            $table->integer('piezasPar');
            $table->float('tiempoPiezas',8, 2);
            $table->float('factorValoracion',8, 2);
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
        Schema::dropIfExists('tb_tiempo_estandar');
    }
}
