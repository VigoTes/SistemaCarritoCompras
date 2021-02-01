<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    protected $table = "SUBCATEGORIA";
    protected $primaryKey = "codSubCategoria";

    public $timestamps = false;  


    protected $fillable = ['nombre','estado','codCategoria','nroEnCategoria'];



}
