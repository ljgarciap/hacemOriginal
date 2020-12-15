<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_mano_de_obra_producto_simula extends Model
{
    protected $table = 'tb_mano_de_obra_producto_simula';

    protected $fillable = ['idPerfil','tiempo','precio','tipoPago','idProducto','idSimulacion'];

    public $timestamps = false;
}
