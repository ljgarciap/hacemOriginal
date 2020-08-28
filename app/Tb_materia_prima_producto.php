<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_materia_prima_producto extends Model
{
    protected $table = 'tb_materia_prima_producto';

    protected $fillable = ['idMateriaPrima','cantidad','precio','tipoDeCosto','idHoja'];

    public $timestamps = false;
}
