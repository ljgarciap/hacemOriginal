<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_rela_simulador extends Model
{
    //
    protected $table = 'tb_rela_simulador';

    protected $fillable = ['idProducto','cantidad','horas','idSimulacion'];

    public $timestamps = false;
}
