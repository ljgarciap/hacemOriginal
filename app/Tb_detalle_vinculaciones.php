<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_detalle_vinculaciones extends Model
{
    //
    protected $fillable = ['idNivelArl','idEps','idPensiones','idVinculacion'];

    public $timestamps = false;
}
