<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_cotizacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idCliente')->constrained('tb_clientes');
            //$table->foreignId('idProveedor')->constrained('tb_proveedores');
            $table->foreignId('idProducto')->constrained('tb_producto');
            $table->date('fecha')->format('Y.m.d');
            $table->float('precioVenta')->default(0);
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
        Schema::dropIfExists('tb_cotizacion');
    }
}
