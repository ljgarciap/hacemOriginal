<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_kardex_almacen extends Model
{
    protected $table = 'tb_kardex_almacen';

    protected $fillable = ['fecha','detalle','cantidad','precio','cantidadSaldos','precioSaldos',
     'idGestionMateria','tipologia'];

    public $timestamps = false;
}
