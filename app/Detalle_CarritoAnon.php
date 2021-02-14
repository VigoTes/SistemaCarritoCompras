<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_CarritoAnon extends Model
{
    protected $table = "DETALLE_CARRITOANON";
    protected $primaryKey = "codDetCarrito";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'cantidad', 'codProducto', 'codCarrito'
    ];

    public function producto(){
        return $this->hasOne('App\Producto','codProducto','codProducto');
    }
}
