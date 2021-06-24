<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Tb_administradora_pensiones;

class Tb_administradora_pensionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tb_administradora_pensiones')->insert([
            'nombrePensiones' => 'Horizonte'
        ]);
        DB::table('tb_administradora_pensiones')->insert([
            'nombrePensiones' => 'Colfondos'
        ]);
        DB::table('tb_administradora_pensiones')->insert([
            'nombrePensiones' => 'Porvenir'
        ]);
        DB::table('tb_administradora_pensiones')->insert([
            'nombrePensiones' => 'Protección'
        ]);
        DB::table('tb_administradora_pensiones')->insert([
            'nombrePensiones' => 'Colpensiones'
        ]);
    }
}
