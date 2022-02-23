<?php

use App\Tb_documentos;
use Illuminate\Database\Seeder;

class Tb_documentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_documentos.json'));
        foreach ($data as $item){
            Tb_documentos::create(array(
                'nombredocumento' => $item->NombreDocumento,
            ));
            }
    }
}
