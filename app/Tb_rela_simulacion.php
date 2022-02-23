<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_rela_simulacion extends Model
{
    //
    protected $table = 'tb_rela_simulacion';

    protected $fillable = ['idProducto','cantidad','horas','idSimulacion'];

    public $timestamps = false;
}
