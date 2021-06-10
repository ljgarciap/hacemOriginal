<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_nomina extends Model
{
    //
    protected $fillable = ['fechaInicio','fechaFin','estado'];

    public $timestamps = false;
}
