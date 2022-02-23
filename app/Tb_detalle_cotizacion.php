<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_detalle_cotizacion extends Model
{
    //
    protected $table = 'tb_detalle_cotizacion';

    protected $fillable = ['cantidad','valor','precioVenta','idProducto','idCotizacion','estado'];

    public $timestamps = false;
}
