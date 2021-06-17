<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Tb_niveles_riesgo;

class Tb_niveles_riesgoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tb_niveles_riesgo')->insert([
            'nivelArl' => '1',
            'porcentajeNivelArl' => '0.1'
        ]);
    }
}
