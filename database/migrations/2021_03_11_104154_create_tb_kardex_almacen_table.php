<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbKardexAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_kardex_almacen', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('detalle', 255);
            $table->float('cantidadEntrada');
            $table->integer('precioEntrada');
            $table->integer('valorEntrada');
            $table->float('cantidadSalida');
            $table->integer('precioSalida');
            $table->integer('valorSalida');
            $table->float('cantidadSaldos');
            $table->integer('precioSaldos');
            $table->integer('valorSaldos');
            $table->foreignId('idGestionMateria')->constrained('tb_gestion_materia_prima');
            $table->boolean('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_kardex_almacen');
    }
}
