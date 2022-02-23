<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_concepto_cif_simula extends Model
{
    protected $table = 'tb_concepto_cif_simula';

    protected $fillable = ['concepto','valor','idSimulacion'];

    public $timestamps = false;
}
