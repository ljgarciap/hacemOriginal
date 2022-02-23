<?php

use Illuminate\Database\Seeder;
use App\Tb_pds;

class Tb_pdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_pds.json'));
        foreach ($data as $item){
            Tb_pds::create(array(
                //'id' => $item->IdRol,
                'idEsfuerzoMental' => $item->idEsfuerzoMental,
                'idEsfuerzoFisico' => $item->idEsfuerzoFisico,
                'idSuplementario' => $item->idSuplementario,
                'idPersonales' => $item->idPersonales,
                'idMonotonia' => $item->idMonotonia,
                'idEspera' => $item->idEspera,
                'idTiempoEstandar' => $item->idTiempoEstandar
            ));
            }
    }
}
