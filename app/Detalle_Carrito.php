<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_Carrito extends Model
{
    protected $table = "DETALLE_CARRITO";
    protected $primaryKey = "codDetCarrito";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'cantidad', 'codProducto', 'codCarrito'
    ];
}
