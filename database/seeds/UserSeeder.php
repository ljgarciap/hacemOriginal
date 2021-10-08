<?php

use Illuminate\Database\Seeder;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Paula',
            'email' => 'pacolmenares02@misena.edu.co',
            'password' => bcrypt('Paula'),
        ]);

        DB::table('users')->insert([
            'name' => 'Freddy',
            'email' => 'freddy.mendez@misena.edu.co',
            'password' => bcrypt('Instructor'),
        ]);

        DB::table('users')->insert([
            'name' => 'Luis',
            'email' => 'ljgarcia899@misena.edu.co',
            'password' => bcrypt('Luis'),
        ]);

        DB::table('users')->insert([
            'name' => 'Luz',
            'email' => 'luzariasarias@misena.edu.co',
            'password' => bcrypt('Instructora'),
        ]);

        DB::table('users')->insert([
            'name' => 'Empresario',
            'email' => 'empresario@gmail.com',
            'password' => bcrypt('Empresario'),
        ]);


        DB::table('users')->insert([
            'name' => 'Alba',
            'email' => 'aluciba@misena.edu.co',
            'password' => bcrypt('Alba'),
        ]);

        DB::table('users')->insert([
            'name' => 'Sergio',
            'email' => 'savargas108@misena.edu.co',
            'password' => bcrypt('Sergio'),
        ]);

        DB::table('users')->insert([
            'name' => 'Edwin',
            'email' => 'djerez31@misena.edu.co',
            'password' => bcrypt('Edwin'),
        ]);

        DB::table('users')->insert([
            'name' => 'Edisson',
            'email' => 'edirusa@misena.edu.co',
            'password' => bcrypt('Edisson'),
        ]);

        DB::table('users')->insert([
            'name' => 'Udes',
            'email' => 'udes@correo.edu.co',
            'password' => bcrypt('12345678'),
        ]);

        DB::table('users')->insert([
            'name' => 'Udes',
            'email' => 'udes@correo.edu.co',
            'password' => bcrypt('12345678'),
        ]);

        DB::table('users')->insert([
            'name' => 'Sandra',
            'email' => 'sgutierrez@sena.edu.co',
            'password' => bcrypt('sgutierrez@sena.edu.co'),
        ]);

        DB::table('users')->insert([
            'name' => 'Lucy',
            'email' => 'letorresb@sena.edu.co',
            'password' => bcrypt('letorresb@sena.edu.co'),
        ]);

    }
}
