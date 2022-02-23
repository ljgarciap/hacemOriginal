<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbOrdenProduccionDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_orden_produccion_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idGestionMateria')->constrained('tb_gestion_materia_prima');
            $table->float('cantidadRequerida');
            $table->float('cantidadEntregada')->default(0);
            $table->foreignId('idOrdenProduccion')->constrained('tb_orden_produccion');
            $table->boolean('estado')->default(1);
            //1 incompleta 0 completa
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_orden_produccion_detalle');
    }
}
