<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_riesgo_adicional extends Model
{
    //
    protected $table = 'tb_riesgo_adicional';

    protected $fillable = ['rangoSalarioMin','rangoSalarioMax','porcentajeAdicional'];

    public $timestamps = false;
}
