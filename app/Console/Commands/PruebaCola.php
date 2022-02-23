<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class PruebaCola extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prueba:cola';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esta es una prueba programada';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return 0;
        $count=0;
        while($count<5){
            sleep(5);
            \Log::info('Esto es una cola programada');
            $texto = "[" . date("Y-m-d H:i:s") . "]: Hola, mi nombre es Sergio Vargas";
            Storage::append("archivo.txt",$texto);
            $count ++;
        }
    }
}
