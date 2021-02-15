<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_CDP extends Model
{
    protected $table = "TIPO_CDP";
    protected $primaryKey = "codTipo";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'nombre'
    ];
}
