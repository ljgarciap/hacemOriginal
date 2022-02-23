<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDetalladoSimuladorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detallado_simulador', function (Blueprint $table) {
            $table->id();
            $table->integer('materiaprima')->unsigned();
            $table->integer('manodeobradirecta')->unsigned();
            $table->integer('costovariableunitario')->unsigned();
            $table->integer('cifaterrizados')->unsigned();
            $table->integer('costototal')->unsigned();
            $table->float('porcentajeganancia');
            $table->integer('costosfijostotales')->unsigned();
            $table->integer('gastosfijos')->unsigned();
            $table->float('porcentajeparticipacion');
            $table->integer('unidadesavender');
            $table->integer('precioventaunitario');
            $table->integer('margencontribucion');
            $table->float('promedioponderado');
            $table->float('puntodeequilibriototal');
            $table->float('puntodeequilibrioproducto');
            $table->foreignId('idProducto')->constrained('tb_producto');
            $table->foreignId('idSimulador')->constrained('tb_simulador');
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
        Schema::dropIfExists('tb_detallado_simulador');
    }
}
