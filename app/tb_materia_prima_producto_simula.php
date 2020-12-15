<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_materia_prima_producto_simula extends Model
{
    protected $table = 'tb_materia_prima_producto_simula';

    protected $fillable = ['idMateriaPrima','cantidad','precio','tipoDeCosto','idProducto','idSimulacion'];

    public $timestamps = false;
}
