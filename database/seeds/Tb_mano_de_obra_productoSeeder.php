<?php

use App\Tb_mano_de_obra_producto;
use Illuminate\Database\Seeder;

class Tb_mano_de_obra_productoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_mano_de_obra_productos.json'));
        foreach ($data as $item){
            Tb_mano_de_obra_producto::create(array(
                //'id' => $item->IdRol,
                'idPerfil' => $item->idPerfil,
                'tiempo' => $item->tiempo,
                'precio' => $item->precio,
                'tipoPago' => $item->tipoPago,
                'idHoja' => $item->idHoja
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
