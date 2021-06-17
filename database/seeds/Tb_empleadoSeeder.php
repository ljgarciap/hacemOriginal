<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Tb_empleado;

class Tb_empleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tb_empleado')->insert([
            'documento' => '12345',
            'idPerfil' => '1',
            'nombre' => 'Empleado',
            'apellido' => 'SuperNumerario',
            'direccion' => 'Av 1 1 1',
			'genero' => '1',
			'telefono' => '111',
			'correo' => 'a@a.a',
            'contacto' => 'Contacto de empleado',
			'telefonocontacto' => '111222',
        ]);

    }
}
