<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Tb_factores_nomina;

class Tb_factores_nominaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_areas.json'));
        foreach ($data as $item){
            Tb_area::create(array(
                //'id' => $item->IdArea,
                'area' => $item->Area,
            ));
            }
        */

        DB::table('tb_factores_nomina')->insert([
            'extraDiurna' => '1.25',
            'extraNocturna' => '1.75',
            'horaDominical' => '1.75',
            'festivaDiurna' => '2',
            'festivaNocturna' => '2.5',
            'recargos' => '0.35',
            'minimolegal' => '908526',
            'auxilio' => '106454',
        ]
        );

    }
}
