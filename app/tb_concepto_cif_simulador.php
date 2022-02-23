<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_concepto_cif_simulador extends Model
{
    protected $table = 'tb_concepto_cif_simulador';

    protected $fillable = ['concepto','valor','idSimulacion'];

    public $timestamps = false;
}
