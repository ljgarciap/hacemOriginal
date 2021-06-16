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
            $table->integer('tipoContrato')->default(1);
            $table->integer('tipoSalario')->default(1);
            $table->integer('salarioBasicoMensual');
            $table->date('fechaInicio');
            $table->date('fechaFin')->default('0000-00-00');
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
