<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_orden_pedido_cliente_detalle extends Model
{
    protected $table = 'tb_orden_pedido_cliente_detalle';

    protected $fillable = ['idProducto','cantidad','precioCosto','precioVenta','idOrdenPedido','estado'];

    public $timestamps = false;

}
