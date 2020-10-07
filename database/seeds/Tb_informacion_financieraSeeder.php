<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Tb_informacion_financiera;

class Tb_informacion_financieraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_informacion_financiera')->insert([
            'conceptoFinanciero' => 'Vacaciones',
            'porcentaje' => '4.17',
        ]);

        DB::table('tb_informacion_financiera')->insert([
            'conceptoFinanciero' => 'Prima',
            'porcentaje' => '8.33',
        ]);

        DB::table('tb_informacion_financiera')->insert([
            'conceptoFinanciero' => 'Cesantias',
            'porcentaje' => '8.33',
        ]);

        DB::table('tb_informacion_financiera')->insert([
            'conceptoFinanciero' => 'Intereses a las cesantias',
            'porcentaje' => '1',
        ]);

        DB::table('tb_informacion_financiera')->insert([
            'conceptoFinanciero' => 'Salud',
            'porcentaje' => '0',
        ]);

        DB::table('tb_informacion_financiera')->insert([
            'conceptoFinanciero' => 'Pensión',
            'porcentaje' => '12',
        ]);

        DB::table('tb_informacion_financiera')->insert([
            'conceptoFinanciero' => 'Arl',
            'porcentaje' => '2.436',
        ]);

        DB::table('tb_informacion_financiera')->insert([
            'conceptoFinanciero' => 'Caja de compensación',
            'porcentaje' => '4',
        ]);
    }
}
