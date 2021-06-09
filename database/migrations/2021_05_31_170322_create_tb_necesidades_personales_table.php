<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbNecesidadesPersonalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_necesidades_personales', function (Blueprint $table) {
            $table->id();
            $table->string('rango');
            $table->float('porcentajeHombre',8, 2);
            $table->float('porcentajeMujer',8, 2);
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
        Schema::dropIfExists('tb_necesidades_personales');
    }
}
