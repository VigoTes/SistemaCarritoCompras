<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_Orden extends Model
{
    protected $table = "DETALLE_ORDEN";
    protected $primaryKey = "codDetalle";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'codOrden', 'cantidad', 'precio','codProducto'
    ];
}
