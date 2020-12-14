<?php

use App\Tb_rela_simulacion;
use Illuminate\Database\Seeder;

class Tb_rela_simulacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_rela_simulaciones.json'));
        foreach ($data as $item){
            Tb_rela_simulacion::create(array(
                //'id' => $item->IdRol,
                'idProducto' => $item->idProducto,
                'unidades' => $item->unidades,
                'tiempo' => $item->tiempo,
                'idSimulacion' => $item->idSimulacion
            ));
            }
        /*
        DB::table('tb_rol')->insert([
            'rol' => 'SuperAdministrador',
        ]);

        DB::table('tb_rol')->insert([
            'rol' => 'Empresario',
        ]
        );
        */
    }
}
