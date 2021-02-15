<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = "DISTRITO";
    protected $primaryKey = "codDistrito";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'nombre', 'codProvincia'
    ];

    public function provincia(){
        return $this->hasOne('App\Provincia','codProvincia','codProvincia');
    }
}
