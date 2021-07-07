<?php

use App\Tb_tipo_nomina;
use Illuminate\Database\Seeder;

class Tb_tipo_nominaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_tipo_nomina.json'));
        foreach ($data as $item){
            Tb_tipo_nomina::create(array(
                //'id' => $item->IdRol,
                'periodicidad' => $item->periodicidad,
                'dias' => $item->dias
            ));
            }
    }
}
