<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_cotizacion extends Model
{
    //
    protected $table = 'tb_cotizacion';

    protected $fillable = ['idCliente','idProveedor','idProducto','fecha','precioVenta','estado'];

    public $timestamps = false;

    public function cliente(){
        return $this->belongsTo('App\Tb_cliente', 'id');
    }

    public function proveedor(){
        return $this->belongsTo('App\Tb_proveedor', 'id');
    }
}
