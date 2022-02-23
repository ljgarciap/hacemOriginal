<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_tipo_nomina extends Model
{
    //
    protected $table = 'tb_tipo_nomina';

    protected $fillable = ['periodicidad','dias'];

    public $timestamps = false;
}
