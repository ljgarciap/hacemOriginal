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
            'password' => bcrypt('Empresario'),
        ]);

        DB::table('users')->insert([
            'name' => 'Freddy',
            'email' => 'freddy.mendez@misena.edu.co',
            'password' => bcrypt('Freddy'),
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
    }
}
