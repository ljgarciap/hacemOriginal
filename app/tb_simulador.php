<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_simulador extends Model
{
    //
    protected $table = 'tb_simulador';

    protected $fillable = ['detalle','fecha','gastosfijos'];

    public $timestamps = false;
}
