<?php

use App\Tb_riesgo_adicional;
use Illuminate\Database\Seeder;

class Tb_riesgo_adicionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_riesgo_adicional.json'));
        foreach ($data as $item){
            Tb_riesgo_adicional::create(array(
                'rangoSalarioMin' => $item->rangoSalarioMin,
                'rangoSalarioMax' => $item->rangoSalarioMax,
                'porcentajeAdicional'=> $item->porcentajeAdicional
            ));
            }
    }
}
