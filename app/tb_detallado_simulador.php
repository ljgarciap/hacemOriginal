<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_detallado_simulador extends Model
{
    //
    protected $table = 'tb_detallado_simulador';

    protected $fillable = ['materiaprima','manodeobradirecta','costovariableunitario','cifaterrizados','costototal',
    'porcentajeganancia','costosfijostotales','gastosfijos','porcentajeparticipacion','unidadesavender',
    'precioventaunitario','margencontribucion','promedioponderado','puntodeequilibriototal','puntodeequilibrioproducto',
    'idProducto','idSimulador'];

    public $timestamps = false;
}
