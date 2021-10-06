<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_arl extends Model
{
    protected $table = 'tb_arl';

    protected $fillable = ['arl'];

    public $timestamps = false;
}
