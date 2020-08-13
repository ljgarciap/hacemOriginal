<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_producto extends Model
{
    protected $table = 'tb_producto';

    protected $fillable = ['nombre','referencia','foto','descripcion','idColeccion','estado'];

    public $timestamps = false;
}
