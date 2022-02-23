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
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_niveles_riesgo.json'));
        foreach ($data as $item){
            Tb_niveles_riesgo::create(array(
                //'id' => $item->IdRol,
                'nivelArl' => $item->nivel,
                'porcentajeNivelArl' => $item->porcentaje
            ));
        }

    }
}
