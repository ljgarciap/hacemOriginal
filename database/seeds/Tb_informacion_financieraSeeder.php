<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Tb_informacion_financiera;

class Tb_informacion_financieraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_informacion_financiera')->insert([
            'vacaciones' => '4.17',
            'prima' => '8.33',
            'cesantias' => '8.33',
            'intereses' => '1',
            'salud' => '0',
            'pension' => '12',
            'arl' => '2.44',
            'caja' => '4',
        ]);
    }
}
