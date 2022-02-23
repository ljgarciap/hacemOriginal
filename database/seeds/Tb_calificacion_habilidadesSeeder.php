<?php

use Illuminate\Database\Seeder;
use App\Tb_calificacion_habilidades;

class Tb_calificacion_habilidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_calificacion_habilidades.json'));
        foreach ($data as $item){
            Tb_calificacion_habilidades::create(array(
                //'id' => $item->IdRol,
                'rango' => $item->rango,
                'porcentaje' => $item->porcentaje,
                'clasificacion' => $item->clasificacion
            ));
            }
    }
}
