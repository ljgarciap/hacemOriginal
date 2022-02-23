<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_multiplicador_horas_extras extends Model
{
    //
    protected $fillable = ['tipoExtra','porcentajeExtra'];

    public $timestamps = false;
}
