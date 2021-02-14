<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;


class ClienteController extends Controller
{

    const PAGINATION='20';



    public function index(Request $request){
        $listaClientes = Cliente::paginate();  
        $buscarpor = $request->buscarpor;

        return view('admin.MantenerClientes.index',compact('listaClientes','buscarpor'));
    }
    
    /* 
    Reporte de las categorias mas consumidas por un Cliente


    */
    
    
    public function reporteClientes($codCliente){



        


    }
}
