<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFactoresNominaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_factores_nomina', function (Blueprint $table) {
            $table->id();
            $table->string('extraDiurna',255);
            $table->string('extraNocturna',255);
            $table->float('horaDominical',8,3);
            $table->string('festivaDiurna',255);
            $table->string('festivaNocturna',255);
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
        Schema::dropIfExists('tb_factores_nomina');
    }
}
