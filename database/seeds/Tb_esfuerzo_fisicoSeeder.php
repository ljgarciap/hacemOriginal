<?php

use Illuminate\Database\Seeder;
use App\Tb_esfuerzo_fisico;

class Tb_esfuerzo_fisicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_esfuerzo_fisico.json'));
        foreach ($data as $item){
            Tb_esfuerzo_fisico::create(array(
                //'id' => $item->IdRol,
                'grado' => $item->grado,
                'porcentaje' => $item->porcentaje
            ));
            }
    }
}
