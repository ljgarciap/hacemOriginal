<?php

use App\Tb_porcentaje_riesgo;
use Illuminate\Database\Seeder;

class Tb_porcentaje_riesgoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_porcentaje_riesgo.json'));
        foreach ($data as $item){
            Tb_porcentaje_riesgo::create(array(
                'nivel' => $item->nivel,
                'porcentaje' => $item->porcentaje
            ));
            }
    }
}
