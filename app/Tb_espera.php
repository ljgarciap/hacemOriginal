<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_espera extends Model
{
    //
    protected $table = 'tb_espera';

    protected $fillable = ['rangoMin','rangoMax','factor'];

    public $timestamps = false;
}
