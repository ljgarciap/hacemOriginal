<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_materia_prima_producto_simulador extends Model
{
    protected $table = 'tb_materia_prima_producto_simulador';

    protected $fillable = ['idMateriaPrima','cantidad','precio','tipoDeCosto','idProducto','idSimulacion'];

    public $timestamps = false;
}
