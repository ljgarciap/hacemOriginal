<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_calificacion_condiciones extends Model
{
    //
    protected $table = 'tb_calificacion_condiciones';

    protected $fillable = ['rango','porcentaje','clasificacion'];

    public $timestamps = false;

}
