<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_necesidades_personales extends Model
{
    //
    protected $table = 'tb_necesidades_personales';

    protected $fillable = ['grado','porcentajeHombre','porcentajeMujer'];

    public $timestamps = false;
}
