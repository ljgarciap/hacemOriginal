<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_detalle_proveedor extends Model
{
    //
    protected $table = 'tb_detalle_proveedor';

    protected $fillable = ['idProducto','cantidad','valor','precioVenta','estado'];

    public $timestamps = false;

}
