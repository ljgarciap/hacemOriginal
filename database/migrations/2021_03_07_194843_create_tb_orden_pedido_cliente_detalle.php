<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbOrdenPedidoClienteDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_orden_pedido_cliente_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idProducto')->constrained('tb_producto');
            $table->float('cantidad');
            $table->integer('precioCosto');
            $table->integer('precioVenta');
            $table->foreignId('idOrdenPedido')->constrained('tb_orden_pedido_cliente');
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
        Schema::dropIfExists('tb_orden_pedido_cliente_detalle');
    }
}
