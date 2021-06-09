<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_westing_house extends Model
{
    //
    protected $table = 'tb_westing_house';

    protected $fillable = ['idHabilidad','idEsfuerzo','idCondiciones','idConsistencia','idTiempoEstandar'];

    public $timestamps = false;
}
