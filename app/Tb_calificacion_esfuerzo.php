<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_calificacion_esfuerzo extends Model
{
    //
    protected $table = 'tb_calificacion_esfuerzo';

    protected $fillable = ['rango','porcentaje','clasificacion'];

    public $timestamps = false;
}
