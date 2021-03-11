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
            $table->foreignId('idProducto')->constrained('tb_producto');
            $table->float('cantidad');
            $table->integer('precioUnitario');
            $table->integer('precioTotal');
            $table->foreignId('idResponsable')->constrained('tb_empleado');
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
