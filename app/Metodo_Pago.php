<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metodo_Pago extends Model
{
    protected $table = "METODO_PAGO";
    protected $primaryKey = "codMetodo";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'nombre'
    ];
}
