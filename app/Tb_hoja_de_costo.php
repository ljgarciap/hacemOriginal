<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_hoja_de_costo extends Model
{
    protected $table = 'tb_hoja_de_costo';

    protected $fillable = ['idProducto','capacidadMensual','estado'];

    public $timestamps = false;

}
