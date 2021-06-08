<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbMultiplicadorHorasExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_multiplicador_horas_extras', function (Blueprint $table) {
            $table->id();
            $table->string('tipoExtra',255);
            $table->float('porcentajeExtra',10,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_multiplicador_horas_extras');
    }
}
