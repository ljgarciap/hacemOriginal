<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_coleccion extends Model
{
    protected $table = 'tb_coleccion';

    protected $fillable = ['nombre','referencia','estado'];

    public $timestamps = false;
}
