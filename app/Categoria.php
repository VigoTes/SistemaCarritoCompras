<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = "CATEGORIA";
    protected $primaryKey = "codCategoria";

    public $timestamps = false;  


    protected $fillable = ['nombre','estado'];

    public function subcategoria(){
        return $this->hasMany('App\SubCategoria','codCategoria','codCategoria');
    }
}
