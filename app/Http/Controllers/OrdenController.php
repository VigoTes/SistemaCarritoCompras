<?php

namespace App\Http\Controllers;

use App\Detalle_Orden;
use Illuminate\Http\Request;
use App\Orden;

class OrdenController extends Controller
{
    const PAGINATE=10;
    //lista todas las ordenes de un cliente
    public function listar($idCliente){
        $listaOrdenes = Orden::where('codCliente','=',$idCliente)->paginate($this::PAGINATE);

        return view('cliente.OrdenesCliente.index',compact('listaOrdenes'));
    }

    //despliega la vista con los detalels de una orden
    public function verDetalles($idOrden){
        
        $orden = Orden::findOrFail($idOrden);
        $listaDetalles = Detalle_Orden::where('codOrden','=',$idOrden)->get();;
        
        return view('cliente.OrdenesCliente.verDetalles',compact('listaDetalles','orden'));

    }

}
