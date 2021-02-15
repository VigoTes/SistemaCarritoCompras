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

    public function getItem(){
        return '1';
    }
    public function getNombreProducto(){
        $prod = Producto::findOrFail($this->codProducto);
        return $prod->nombre;
    }

    


}
