<?php

use Illuminate\Database\Seeder;
use App\Tb_monotonia;

class Tb_monotoniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_monotonia.json'));
        foreach ($data as $item){
            Tb_monotonia::create(array(
                //'id' => $item->IdRol,
                'rangoMin' => $item->rangoMin,
                'rangoMax' => $item->rangoMax,
                'clasificacion'=>$item->clasificacion,
                'porcentaje'=>$item->porcentaje
            ));
            }
    }
}
