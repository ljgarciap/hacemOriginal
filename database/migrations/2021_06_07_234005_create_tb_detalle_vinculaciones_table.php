<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDetalleVinculacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detalle_vinculaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idNivelArl')->constrained('tb_niveles_riesgo');
            $table->foreignId('idEps')->constrained('tb_eps');
            $table->foreignId('idPensiones')->constrained('tb_administradora_pensiones');
            $table->foreignId('idVinculacion')->constrained('tb_vinculaciones');
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
        Schema::dropIfExists('tb_detalle_vinculaciones');
    }
}
