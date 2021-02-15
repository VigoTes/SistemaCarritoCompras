<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = "REGION";
    protected $primaryKey = "codRegion";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'nombre', 'codPais'
    ];

    public function pais(){
        return $this->hasOne('App\Pais','codPais','codPais');
    }
}
