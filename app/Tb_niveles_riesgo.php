<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_niveles_riesgo extends Model
{
    //
    protected $table = 'tb_niveles_riesgo';

    protected $fillable = ['nivelArl','porcentajeNivelArl'];

    public $timestamps = false;

}
