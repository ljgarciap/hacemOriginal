<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_novedades extends Model
{
    //
    protected $fillable = ['fechaNovedad','concepto','valor','idEmpleado','idNomina'];

    public $timestamps = false;
}
