<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_rol extends Model
{
    protected $table = 'tb_rol';

    protected $fillable = ['rol','estado'];

    public $timestamps = false;

    public function users() {
        return $this->belongsToMany('App\User','tb_usuario_tiene_rol', 'idRol', 'idUser');
    }
}
