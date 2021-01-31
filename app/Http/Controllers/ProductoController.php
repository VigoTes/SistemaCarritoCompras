<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    
    public function listarProductos(){
        $productos = Producto::all();
        
        
        return $productos;

    }

}
