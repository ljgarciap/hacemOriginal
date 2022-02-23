<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_calificacion_habilidades extends Model
{
    //
    protected $table = 'tb_calificacion_habilidades';

    protected $fillable = ['rango','porcentaje','clasificacion'];

    public $timestamps = false;
}
