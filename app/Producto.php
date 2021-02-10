<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categoria;
use App\SubCategoria;
use App\Marca;

class Producto extends Model
{
    protected $table = "PRODUCTO";
    protected $primaryKey = "codProducto";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        // le indicamos los campos de la tabla 
        protected $fillable = ['nombre','descripcion','codSubCategoria'
        ,'codMarca','stock','precioActual','descuento','fechaActualizacion','estado','contadorVentas'];

    public function getNombreMarca(){
        $marca = Marca::findOrFail($this->codMarca);
        return $marca->nombre;
    }   

    public function getNombreSubCategoria(){
        $subCategoria = SubCategoria::findOrFail($this->codSubCategoria);
        return $subCategoria->nombre;
    }   
    
    public function getNombreCategoria(){
        $subCategoria = SubCategoria::findOrFail($this->codSubCategoria);
        
        $categoria = Categoria::findOrFail($subCategoria->codCategoria);
        return $categoria->nombre;
    }   
    


}
