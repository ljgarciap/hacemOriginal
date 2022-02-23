<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_mano_de_obra_producto_simulador extends Model
{
    protected $table = 'tb_mano_de_obra_producto_simulador';

    protected $fillable = ['idPerfil','tiempo','precio','tipoPago','idProducto','idSimulacion'];

    public $timestamps = false;
}
