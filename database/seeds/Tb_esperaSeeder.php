<?php

use Illuminate\Database\Seeder;
use App\Tb_espera;

class Tb_esperaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_espera.json'));
        foreach ($data as $item){
            Tb_espera::create(array(
                //'id' => $item->IdRol,
                'rangoMin' => $item->rangoMin,
                'rangoMax' => $item->rangoMax,
                'factor'=>$item->factor,
            ));
            }
    }
}
