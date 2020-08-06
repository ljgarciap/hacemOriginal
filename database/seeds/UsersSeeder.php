<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Francisco',
            'email' => 'fatuta1@misena.edu.co',
            'password' => 'Francisco',
        ]);
        DB::table('users')->insert([
            'name' => 'Freddy',
            'email' => 'freddy.mendez@misena.edu.co',
            'password' => 'Freddy',
        ]);
        DB::table('users')->insert([
            'name' => 'Luis',
            'email' => 'ljgarcia899@misena.edu.co',
            'password' => 'Luis',
        ]);
        DB::table('users')->insert([
            'name' => 'Empresario',
            'email' => 'empresario@gmail.com',
            'password' => 'Empresario'
        ]);
    }
}
