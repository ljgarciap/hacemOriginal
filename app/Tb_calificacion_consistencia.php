<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_calificacion_consistencia extends Model
{
    //
    protected $table = 'tb_calificacion_consistencia';

    protected $fillable = ['rango','porcentaje','clasificacion'];

    public $timestamps = false;
}
