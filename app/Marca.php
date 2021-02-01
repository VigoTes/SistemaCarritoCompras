<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = "MARCA";
    protected $primaryKey = "codMarca";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
        protected $fillable = ['nombre','estado'];
}
