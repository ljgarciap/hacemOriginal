<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_mano_de_obra_producto extends Model
{
    protected $table = 'tb_mano_de_obra_producto';

    protected $fillable = ['idPerfil','tiempo','precio','tipoPago','idHoja'];

    public $timestamps = false;

    // Relacion con la tabla perfil
    public function coleccion(){
        return $this->belongsTo('App\Tb_perfil', 'idPerfil');
    }
}
