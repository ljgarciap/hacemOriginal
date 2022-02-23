<?php

use App\Tb_materia_prima_producto;
use Illuminate\Database\Seeder;

class Tb_materia_prima_productoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_materia_prima_productos.json'));
        foreach ($data as $item){
            Tb_materia_prima_producto::create(array(
                //'id' => $item->IdRol,
                'idMateriaPrima' => $item->idMateriaPrima,
                'cantidad' => $item->cantidad,
                'precio' => $item->precio,
                'tipoDeCosto' => $item->tipoDeCosto,
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
