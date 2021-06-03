<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_empleado', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('documento');
            $table->foreignId('idPerfil')->constrained('tb_perfil');
            $table->string('nombre',255);
            $table->string('apellido',255);
            $table->string('direccion',255);
            $table->integer('genero')->unsigned();
            $table->bigInteger('telefono');
            $table->string('correo',255);
            $table->boolean('estado')->default(1);
           // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_empleado');
    }
}
