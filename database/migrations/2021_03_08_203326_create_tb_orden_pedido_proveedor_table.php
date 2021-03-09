<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbOrdenPedidoProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_orden_pedido_proveedor', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',255);
            $table->date('fecha')->format('Y.m.d');
            $table->float('precio')->default(0);
            $table->foreignId('idProveedor')->constrained('tb_proveedores');
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
        Schema::dropIfExists('tb_orden_pedido_proveedor');
    }
}
