<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_eps extends Model
{
    //
    protected $table = 'tb_eps';

    protected $fillable = ['nombreEps'];

    public $timestamps = false;
}
