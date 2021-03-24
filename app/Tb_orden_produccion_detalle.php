<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_orden_produccion_detalle extends Model
{
    //
    protected $table = 'tb_orden_produccion_detalle';

    protected $fillable = ['idGestionMateria','cantidadRequerida','cantidadEntregada','idOrdenProduccion','estado'];

    public $timestamps = false;
}
