<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbMateriaPrimaProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_materia_prima_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idMateriaPrima')->constrained('tb_gestion_materia_prima');
            $table->float('cantidad');
            $table->integer('precio')->unsigned();
            $table->string('tipoDeCosto', 255);
            $table->foreignId('idHoja')->constrained('tb_hoja_de_costo');
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
        Schema::dropIfExists('tb_materia_prima_producto');
    }
}
