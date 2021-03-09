<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_orden_pedido_proveedor extends Model
{
    //
    protected $table = 'tb_orden_pedido_proveedor';

    protected $fillable = ['idProveedor','fecha','estado'];

    public $timestamps = false;
   
    public function proveedor(){
        return $this->belongsTo('App\Tb_proveedor', 'id');
    }
}
