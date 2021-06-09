<?php

use Illuminate\Database\Seeder;
use App\Tb_calificacion_condiciones;

class Tb_calificacion_condicionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_calificacion_condiciones.json'));
        foreach ($data as $item){
            Tb_calificacion_condiciones::create(array(
                //'id' => $item->IdRol,
                'rango' => $item->rango,
                'porcentaje' => $item->porcentaje,
                'clasificacion' => $item->clasificacion
            ));
            }
    }
}
