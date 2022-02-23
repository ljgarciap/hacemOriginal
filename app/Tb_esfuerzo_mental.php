<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_esfuerzo_mental extends Model
{
    //
    protected $table = 'tb_esfuerzo_mental';

    protected $fillable = ['grado','porcentaje'];

    public $timestamps = false;
}
