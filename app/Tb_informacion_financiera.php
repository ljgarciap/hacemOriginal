<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_informacion_financiera extends Model
{
    protected $table = 'tb_informacion_financiera';

    protected $fillable = ['vacaciones','prima','cesantias','intereses','salud','pension','arl','caja'];

    public $timestamps = false;
}
