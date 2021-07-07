<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_porcentaje_riesgo extends Model
{
    //
    protected $table = 'tb_porcentaje_riesgo';

    protected $fillable = ['nivel','porcentaje'];

    public $timestamps = false;
}
