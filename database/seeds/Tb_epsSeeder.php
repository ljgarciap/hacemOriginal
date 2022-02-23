<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Tb_eps;

class Tb_epsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tb_eps')->insert([
            'nombreEps' => 'NUEVA EPS'
        ]);
        DB::table('tb_eps')->insert([
            'nombreEps' => 'SANITAS'
        ]);
        DB::table('tb_eps')->insert([
            'nombreEps' => 'SALUD TOTAL'
        ]);
        DB::table('tb_eps')->insert([
            'nombreEps' => 'MEDIMAS'
        ]);
        DB::table('tb_eps')->insert([
            'nombreEps' => 'FAMISANAR'
        ]);

    }
}
