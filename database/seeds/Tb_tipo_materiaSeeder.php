<?php

use App\Tb_tipo_materia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tb_tipo_materiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_tipo_materia')->insert([
            'tipoMateria' => 'Material Principal',
        ]);

        DB::table('tb_tipo_materia')->insert([
            'tipoMateria' => 'Material Secundario',
        ]);

        DB::table('tb_tipo_materia')->insert([
            'tipoMateria' => 'Herrajes',
        ]);

        DB::table('tb_tipo_materia')->insert([
            'tipoMateria' => 'Insumos',
        ]);
    }
}
