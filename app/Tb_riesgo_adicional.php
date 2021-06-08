<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_riesgo_adicional extends Model
{
    //
    protected $fillable = ['sueldoMaximo','porcentajeAdicional'];

    public $timestamps = false;
}
