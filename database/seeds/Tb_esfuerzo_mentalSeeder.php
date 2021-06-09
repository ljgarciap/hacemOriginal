<?php

use Illuminate\Database\Seeder;
use App\Tb_esfuerzo_mental;

class Tb_esfuerzo_mentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_esfuerzo_mental.json'));
        foreach ($data as $item){
            Tb_esfuerzo_mental::create(array(
                //'id' => $item->IdRol,
                'grado' => $item->grado,
                'porcentaje' => $item->porcentaje
            ));
            }
    }
}
