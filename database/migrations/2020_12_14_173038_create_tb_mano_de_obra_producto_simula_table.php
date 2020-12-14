<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbManoDeObraProductoSimulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_mano_de_obra_producto_simula', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPerfil')->constrained('tb_perfil');
            $table->float('tiempo')->default(1);
            $table->integer('precio')->unsigned();
            $table->integer('tipoPago')->unsigned();
            $table->foreignId('idProducto')->constrained('tb_producto');
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
        Schema::dropIfExists('tb_mano_de_obra_producto_simula');
    }
}
