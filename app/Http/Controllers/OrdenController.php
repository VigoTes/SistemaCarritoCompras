<?php

namespace App\Http\Controllers;

use DateTime;
use App\Detalle_Orden;
use Illuminate\Http\Request;
use App\Orden;
use App\Cliente;
use App\Domicilio;


use App\Producto;
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
        $domicilioDestino = Domicilio::findOrFail($orden->codDomicilio);
        $listaDetalles = Detalle_Orden::where('codOrden','=',$idOrden)->get();;
        
        return view('cliente.OrdenesCliente.verDetalles',compact('listaDetalles','orden','domicilioDestino'));

    }

    /* DESPLIEGA LA VISTA DE ORDENES */
    public function listarParaAdmin(){
        $listaOrdenes = Orden::where('codEstado','<','5')
            ->orderby('codEstado','ASC')
            ->orderby('fechaHoraVenta','DESC')
            ->paginate($this::PAGINATE);



        return view('admin.MantenerOrdenes.index',compact('listaOrdenes'));

    }

    /* DSPLIEGA LA VISTA DE REVISION PARA VER SI LA PROCESAN O NO  (ES PARA PASAR AL SIGUIENTE ESTADO)*/
    public function revisarOrden($idOrden){
        $orden = Orden::findOrFail($idOrden);
        $cliente = Cliente::findOrFail($orden->codCliente);
        $listaDetalles = Detalle_Orden::where('codOrden','=',$idOrden)->get();;
        $domicilioDestino = Domicilio::findOrFail($orden->codDomicilio);


        return view('admin.MantenerOrdenes.revisarOrden',compact('listaDetalles','orden','cliente','domicilioDestino'));
    }

    //pasa al siguiente estado la orden
    public function next($idOrden){

        $orden = Orden::findOrFail($idOrden);
        $orden->codEstado  = $orden->codEstado +1;
        $orden->save(); 
            return redirect()->route('orden.listarParaAdmin')->with('datos','Orden actualizada a '.$orden->getNombreEstado());
    }

    public function cancelar($idOrden){
        $orden = Orden::findOrFail($idOrden);
        $orden->codEstado  = 5;
        $orden->save(); 


        $detalles=Detalle_Orden::where('codOrden','=',$orden->codOrden)->get();
        //obtenemos los detalles y regresamos el stock a esos productos
        foreach ($detalles as $itemdetalle) {
            //actualizar stock
            $productoTemp=Producto::find($itemdetalle->codProducto);
            $productoTemp->stock+=$itemdetalle->cantidad;
            $productoTemp->contadorVentas-=$itemdetalle->cantidad;
            $productoTemp->save();

            //no borramos los det de la orden pq tiene que quedar registro
        }

            return redirect()->route('orden.listarParaAdmin')->with('datos','Orden '.$orden->codOrden.' Cancelada.' );
    }



    public function generarCDP($id){
        date_default_timezone_set('America/Lima');
        //COMANDO PARA EL COMPLEMENTO PARA PDF
        //composer require barryvdh/laravel-dompdf
        //COMPOSER: es un gestor para dependencias de laravel en la nube (se guarda en vendor)

        //$pdf = \PDF::loadView('modulos.caja.CDP')->setPaper(array(0, 0, 301, 623.622), 'portrait');
        

        $orden=Orden::find($id);
        $detalles=Detalle_Orden::where('codOrden','=',$orden->codOrden)->get();
        $fechaHora=new DateTime();
        $domicilio=Domicilio::find($orden->codDomicilio);

        $pdf = \PDF::loadView('cliente.CDP',array('orden'=>$orden,'domicilio'=>$domicilio,
                                                        'detalles'=>$detalles,
                                                        'fechaHora'=>$fechaHora,
                                                        'tipo'=>2));
        $pdf->setPaper(array(0, 0, 301, 623.622), 'portrait');
        //$pdf->set_option('defaultFont', 'Courier');
        
        //var_dump($data[0]->elementos->descripcionElemento);

        //return $pdf->download('dinamicoV1.pdf');
        return $pdf->stream();
    }

}
