<?php

use Illuminate\Database\Seeder;
use App\Tb_calificacion_consistencia;

class Tb_calificacion_consistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_calificacion_consistencia.json'));
        foreach ($data as $item){
            Tb_calificacion_consistencia::create(array(
                //'id' => $item->IdRol,
                'rango' => $item->rango,
                'porcentaje' => $item->porcentaje,
                'clasificacion' => $item->clasificacion
            ));
            }
    }
}
