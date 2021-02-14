<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    

    protected $table = "CLIENTE";
    protected $primaryKey = "codCliente";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'nombres', 'apellidos','nroTelefonoMovil'
    ];

    


}
