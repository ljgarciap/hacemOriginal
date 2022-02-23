<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\tb_arl;

class Tb_arlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_arl')->insert([
            'arl' => 'POSITIVA'
        ]);
        DB::table('tb_arl')->insert([
            'arl' => 'COLMENA'
        ]);
        DB::table('tb_arl')->insert([
            'arl' => 'COLPATRIA'
        ]);
        DB::table('tb_arl')->insert([
            'arl' => 'LA EQUIDAD'
        ]);
        DB::table('tb_arl')->insert([
            'arl' => 'MAPFRE'
        ]);
        DB::table('tb_arl')->insert([
            'arl' => 'SEGUROS BOLIVAR'
        ]);
        DB::table('tb_arl')->insert([
            'arl' => 'LIBERTY'
        ]);
        DB::table('tb_arl')->insert([
            'arl' => 'SURAMERICANA'
        ]);
    }
}
