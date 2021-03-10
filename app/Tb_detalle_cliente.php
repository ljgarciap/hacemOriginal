<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_detalle_cliente extends Model
{
    //
    protected $table = 'tb_detalle_cliente';

    protected $fillable = ['idProducto','cantidad','valor','precioVenta','estado'];

    public $timestamps = false;
}
