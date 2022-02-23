<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\tb_caja_compensacion;

class Tb_caja_compensacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_caja_compensacion')->insert([
            'cajaCompensacion' => 'CAJASAN'
        ]);
        DB::table('tb_caja_compensacion')->insert([
            'cajaCompensacion' => 'COMFENALCO'
        ]);
    }
}
