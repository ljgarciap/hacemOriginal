<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDetalleInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detalle_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idProducto')->constrained('tb_gestion_materia_prima');
            $table->string('cantidad');
            $table->string('observacion');
            $table->foreignId('idInventario')->constrained('tb_inventario');
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
        Schema::dropIfExists('tb_detalle_inventario');
    }
}
