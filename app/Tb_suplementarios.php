<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_suplementarios extends Model
{
    //
    protected $table = 'tb_suplementarios';

    protected $fillable = ['grado','porcentaje'];

    public $timestamps = false;
}
