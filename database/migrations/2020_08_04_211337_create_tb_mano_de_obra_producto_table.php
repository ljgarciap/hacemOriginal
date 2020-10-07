<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbManoDeObraProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_mano_de_obra_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPerfil')->constrained('tb_perfil');
            $table->float('tiempo')->default(1);
            $table->integer('precio')->unsigned();
            $table->integer('tipoPago')->unsigned();
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
        Schema::dropIfExists('tb_mano_de_obra_producto');
    }
}
