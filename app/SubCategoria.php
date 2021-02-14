<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    protected $table = "SUBCATEGORIA";
    protected $primaryKey = "codSubCategoria";

    public $timestamps = false;  


    protected $fillable = ['nombre','estado','codCategoria','nroEnCategoria'];

    public function categoria(){
        return $this->hasOne('App\Categoria','codCategoria','codCategoria');
    }

}
