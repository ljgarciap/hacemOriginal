<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_vinculaciones extends Model
{
    //
    protected $fillable = ['tipoVinculacion','salarioBasicoMensual','fechaInicio','fechaFin','idEmpleado'];

    public $timestamps = false;
}
