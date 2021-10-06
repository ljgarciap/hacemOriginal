<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_caja_compensacion extends Model
{
    protected $table = 'tb_caja_compensacion';

    protected $fillable = ['cajaCompensacion'];

    public $timestamps = false;
}
