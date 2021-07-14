<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_factores_nomina extends Model
{
    //
    protected $table = 'tb_factores_nomina';

    protected $fillable = ['extraDiurna','extraNocturna','horaDominical','festivaDiurna','festivaNocturna','recargos','minimolegal','auxilio'];

    public $timestamps = false;
}
