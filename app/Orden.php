<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = "ORDEN";
    protected $primaryKey = "codOrden";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'codMetodo', 'total','codDomicilio','codCliente','codCliente','fechaHoraVenta','codTipo','totalIGV'
    ];
}
