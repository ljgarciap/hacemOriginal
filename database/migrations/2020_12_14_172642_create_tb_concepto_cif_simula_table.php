<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbConceptoCifSimulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_concepto_cif_simula', function (Blueprint $table) {
            $table->id();
            $table->string('concepto', 255);
            $table->integer('valor');
            $table->foreignId('idSimulacion')->constrained('tb_simulacion');
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
        Schema::dropIfExists('tb_concepto_cif_simula');
    }
}
