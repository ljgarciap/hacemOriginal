<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_esfuerzo_fisico extends Model
{
    //
    protected $table = 'tb_esfuerzo_fisico';

    protected $fillable = ['grado','porcentaje'];

    public $timestamps = false;
}
