<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDetalleCotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detalle_cotizacion', function (Blueprint $table) {
            $table->id();
            $table->float('cantidad');
            $table->integer('valor');
            $table->integer('precioVenta');
            $table->foreignId('idProducto')->constrained('tb_producto');
            $table->foreignId('idCotizacion')->constrained('tb_cotizacion');
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
        Schema::dropIfExists('tb_detalle_cotizacion');
    }
}
