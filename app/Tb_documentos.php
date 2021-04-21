<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_documentos extends Model
{
    //
    protected $table = 'tb_documentos';

    protected $fillable = ['nombredocumento'];

    public $timestamps = false;
}
