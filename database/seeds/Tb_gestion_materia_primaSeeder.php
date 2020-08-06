<?php

use App\Tb_gestion_materia_prima;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tb_gestion_materia_primaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_gestion_materia_prima')->insert([
            'nombre' => 'Prueba',
            'idUnidadBase' => '1',
            'precioBase' => '0',
            'idtipoMateria' => '1',
        ]);
    }
}
