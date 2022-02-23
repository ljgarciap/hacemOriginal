<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbConceptoCifSimuladorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_concepto_cif_simulador', function (Blueprint $table) {
            $table->id();
            $table->string('concepto', 255);
            $table->integer('valor');
            $table->foreignId('idSimulacion')->constrained('tb_simulador');
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
        Schema::dropIfExists('tb_concepto_cif_simulador');
    }
}
