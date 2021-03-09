<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_proveedor extends Model
{
    //
    protected $table = 'tb_proveedores';

    protected $fillable = ['nit','telefono','direccion','correo','estado'];

    public $timestamps = false;

    public function cotizaciones(){
        return $this->hasMany('App\Tb_cotizacion');
    }

    public function ordenProveedor(){
        return $this->hasMany('App\Tb_orden_pedido_proveedor');
    }
}
