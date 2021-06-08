<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_tipo_nomina extends Model
{
    //
    protected $fillable = ['periodicidad','dias'];

    public $timestamps = false;
}
