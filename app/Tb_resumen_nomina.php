<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_resumen_nomina extends Model
{
    //
    protected $table = 'tb_resumen_nomina';

    protected $fillable = ['sueldoBasicoMensual','idEmpleado','idNomina'];

    public $timestamps = false;
}
