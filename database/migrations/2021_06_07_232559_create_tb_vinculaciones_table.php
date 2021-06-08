<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbVinculacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_vinculaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('tipoVinculacion')->default(1);
            $table->integer('salarioBasicoMensual');
            $table->date('fechaInicio');
            $table->date('fechaFin');
            $table->foreignId('idEmpleado')->constrained('tb_empleado');
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
        Schema::dropIfExists('tb_vinculaciones');
    }
}
