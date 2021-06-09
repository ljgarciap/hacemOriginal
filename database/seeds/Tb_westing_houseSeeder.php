<?php

use Illuminate\Database\Seeder;
use App\Tb_westing_house;

class Tb_westing_houseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_westing_house.json'));
        foreach ($data as $item){
            Tb_westing_house::create(array(
                //'id' => $item->IdRol,
                'idHabilidad' => $item->idHabilidad,
                'idEsfuerzo' => $item->idEsfuerzo,
                'idCondiciones' => $item->idCondiciones,
                'idConsistencia' => $item->idConsistencia,
                'idTiempoEstandar' => $item->idTiempoEstandar
            ));
            }
    }
}
