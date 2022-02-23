<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_rela_simulador extends Model
{
    //
    protected $table = 'tb_rela_simulador';

    protected $fillable = ['idProducto','unidades','idPrecio','idSimulador'];

    public $timestamps = false;
}
