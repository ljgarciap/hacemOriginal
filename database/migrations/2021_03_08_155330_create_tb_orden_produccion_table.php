<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbOrdenProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_orden_produccion', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->format('Y.m.d');
            $table->string('detalle',255);
            $table->string('responsable',255);
            $table->string('bodega',255);
            $table->string('medida',255);
            $table->float('cantidad');
            $table->integer('precioUnitario');
            $table->integer('precioTotal');
            $table->foreignId('idProducto')->constrained('tb_producto');
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('tb_orden_produccion');
    }
}
