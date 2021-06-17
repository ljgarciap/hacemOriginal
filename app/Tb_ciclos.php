<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_ciclos extends Model
{
    //
    protected $table = 'tb_ciclos';

    protected $fillable = ['tiempo','piezas','idTiempoEstandar'];

    public $timestamps = false;

    public function tiempoestandar(){
        return $this->hasMany('App\Tb_ciclos');
    }
}
