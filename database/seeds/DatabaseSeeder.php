<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_area'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_areaSeeder::class);
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_proceso'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_procesoSeeder::class);
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_perfil'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_perfilSeeder::class);
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_rol'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_rolSeeder::class);
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'users'
        ]);

        //funcion principal que llama cada seeder
        $this->call(UserSeeder::class);
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_usuario_tiene_rol'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_usuario_tiene_rolSeeder::class);
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_unidad_base'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_unidad_baseSeeder::class);
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_tipo_materia'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_tipo_materiaSeeder::class);
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_gestion_materia_prima'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_gestion_materia_primaSeeder::class);

//--Tener cuidado con este cierre--//
    }
//--Tener cuidado con este cierre--//

    //funcion que deshabilita revision de claves foraneas para borrar tablas y luego la habilita nuevamente
    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
