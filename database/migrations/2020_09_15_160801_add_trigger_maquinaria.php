<?php

use App\Tb_maquinaria;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTriggerMaquinaria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER depreciacion BEFORE INSERT ON tb_maquinaria FOR EACH ROW

        BEGIN
        SET NEW.depreciacionAnual = ROUND(NEW.valor / NEW.tiempoDeVidaUtil);
        SET NEW.depreciacionMensual = ROUND((NEW.valor / NEW.tiempoDeVidaUtil)/12);
       END");

        DB::unprepared("CREATE TRIGGER depreciacionupdate BEFORE UPDATE ON tb_maquinaria FOR EACH ROW

        BEGIN
        IF (new.valor != old.valor and new.tiempoDeVidaUtil !=old.tiempoDeVidaUtil) THEN
        set new.depreciacionAnual = ROUND(new.valor/new.tiempoDeVidaUtil);
        set new.depreciacionMensual = ROUND((new.valor / new.tiempoDeVidaUtil)/12);
        ELSEIF (new.valor != old.valor) THEN
        set new.depreciacionAnual = ROUND(new.valor/old.tiempoDeVidaUtil);
        set new.depreciacionMensual = ROUND((new.valor / old.tiempoDeVidaUtil)/12);
        ELSE
        set new.depreciacionAnual = ROUND(old.valor/new.tiempoDeVidaUtil);
        set new.depreciacionMensual = ROUND((old.valor / new.tiempoDeVidaUtil)/12);
        END IF;

        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER depreciacion");
        DB::unprepared("DROP TRIGGER depreciacionupdate");
    }
}