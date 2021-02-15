<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado_Orden extends Model
{
    
    protected $table = "ESTADO_ORDEN";
    protected $primaryKey = "codEstado";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
        protected $fillable = ['nombre'];


}
