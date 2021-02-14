<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarritoAnon extends Model
{
    protected $table = "CARRITOANON";
    protected $primaryKey = "idAI";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = ['codCarrito'];
}
