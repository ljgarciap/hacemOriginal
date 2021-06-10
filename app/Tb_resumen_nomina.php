<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_resumen_nomina extends Model
{
    //
    protected $fillable = ['sueldoBasicoMensual','idEmpleado','idNomina'];

    public $timestamps = false;
}
