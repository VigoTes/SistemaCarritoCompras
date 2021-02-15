<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = "PROVINCIA";
    protected $primaryKey = "codProvincia";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'nombres', 'codRegion'
    ];

    public function region(){
        return $this->hasOne('App\Region','codRegion','codRegion');
    }
}
