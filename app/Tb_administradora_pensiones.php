<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_administradora_pensiones extends Model
{
    //
    protected $table = 'tb_administradora_pensiones';

    protected $fillable = ['nombrePensiones'];

    public $timestamps = false;
}
