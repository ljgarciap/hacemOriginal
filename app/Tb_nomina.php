<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_nomina extends Model
{
    //
    protected $table = 'tb_nomina';

    protected $fillable = ['fechaInicio','fechaFin','tipo','estado'];

    public $timestamps = false;
}
