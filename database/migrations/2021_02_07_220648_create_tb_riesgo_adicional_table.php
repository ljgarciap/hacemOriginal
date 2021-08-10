<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbRiesgoAdicionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_riesgo_adicional', function (Blueprint $table) {
            $table->id();
            $table->float('rangoSalarioMin',8, 6);
            $table->float('rangoSalarioMax',8, 6);
            $table->float('porcentajeAdicional',8, 4);
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
        Schema::dropIfExists('tb_riesgo_adicional');
    }
}
