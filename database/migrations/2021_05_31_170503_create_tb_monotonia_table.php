<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbMonotoniaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_monotonia', function (Blueprint $table) {
            $table->id();
            $table->float('rangoMin',8, 2);
            $table->float('rangoMax',8, 2);
            $table->string('clasificacion',255);
            $table->float('porcentaje',8, 2);
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
        Schema::dropIfExists('tb_monotonia');
    }
}
