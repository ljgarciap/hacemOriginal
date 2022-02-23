<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbInformacionFinancieraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_informacion_financiera', function (Blueprint $table) {
            $table->id();
            $table->float('vacaciones')->default(0);
            $table->float('prima')->default(0);
            $table->float('cesantias')->default(0);
            $table->float('intereses')->default(0);
            $table->float('salud')->default(0);
            $table->float('pension')->default(0);
            $table->float('arl')->default(0);
            $table->float('caja')->default(0);
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
        Schema::dropIfExists('tb_informacion_financiera');
    }
}
