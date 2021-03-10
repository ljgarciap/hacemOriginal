<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_empleado extends Model
{
    //
    protected $table = 'tb_empleado';

    protected $fillable = ['documento','idPerfil','nombre','apellido','direccion','telefono','correo','estado'];

    public $timestamps = false;

    public function perfiles(){
        return $this->hasMany('App\Tb_perfil');
    }
}
