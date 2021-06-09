<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_pds extends Model
{
    //
    protected $table = 'tb_pds';

    protected $fillable = ['idEsfuerzoMental','idEsfuerzoFisico','idSuplementarios','idPersonales','idMonotonia','idEspera','idTiempoEstandar'];

    public $timestamps = false;
}
