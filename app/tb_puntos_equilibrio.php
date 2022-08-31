<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_puntos_equilibrio extends Model
{
    //
    protected $table = 'tb_puntos_equilibrio';

    protected $fillable = ['idProducto','preciodeventa','costosfijos','gastosfijos','materiaprima','manodeobradirecta','puntodeequilibrio','detalle'];

    public $timestamps = false;
}
