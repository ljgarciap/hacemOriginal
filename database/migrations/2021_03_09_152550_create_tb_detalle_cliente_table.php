<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDetalleClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detalle_cliente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idProducto')->constrained('tb_producto');
            $table->float('cantidad');
            $table->integer('valor');
            $table->integer('precioVenta');
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
        Schema::dropIfExists('tb_detalle_cliente');
    }
}
