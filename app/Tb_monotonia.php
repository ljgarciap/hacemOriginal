<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_monotonia extends Model
{
    //
    protected $table = 'tb_monotonia';

    protected $fillable = ['rangoMin','rangoMax','clasificacion','porcentaje'];

    public $timestamps = false;
}
