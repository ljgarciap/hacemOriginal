<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_perfil extends Model
{
    protected $table = 'tb_perfil';

    protected $fillable = ['perfil','idProceso','valorMinuto','estado'];

    public $timestamps = false;

    public function procesos(){
        return $this->belongsTo('App\Tb_proceso', 'idProceso');
    }

    public function empleado(){
        return $this->belongsTo('App\Tb_empleado', 'id');
    }
}
