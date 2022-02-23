<?php

use Illuminate\Database\Seeder;
use App\Tb_suplementarios;

class Tb_suplementariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_suplementarios.json'));
        foreach ($data as $item){
            Tb_suplementarios::create(array(
                //'id' => $item->IdRol,
                'grado' => $item->grado,
                'porcentaje' => $item->porcentaje
            ));
            }
    }
}
