<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_novedades extends Model
{
    //
    protected $fillable = ['fechaNovedad','concepto','valor','tipologia','idEmpleado','idNomina'];

    public $timestamps = false;
}
