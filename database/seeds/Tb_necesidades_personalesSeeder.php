<?php

use Illuminate\Database\Seeder;
use App\Tb_necesidades_personales;

class Tb_necesidades_personalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_necesidades_personales.json'));
        foreach ($data as $item){
            Tb_necesidades_personales::create(array(
                //'id' => $item->IdRol,
                'rango' => $item->rango,
                'porcentajeHombre' => $item->porcentajeHombre,
                'porcentajeMujer'=>$item->porcentajeMujer
            ));
            }
    }
}
