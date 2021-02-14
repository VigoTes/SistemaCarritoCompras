<?php

namespace App\Http\Controllers;

use App\Carrito;
use App\CarritoAnon;
use App\Detalle_Carrito;
use App\Detalle_CarritoAnon;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cliente;

class CarritoController extends Controller
{



    public function eliminarProducto($idProducto){

        if(is_null(Auth::user())){ 
            //caso anon
            $codCarritoAnon = session('token');
            $ListadetalleCarrito = Detalle_CarritoAnon::where('codProducto','=',$idProducto)
            ->where('codCarrito','=',$codCarritoAnon)->get();
        }else{ //cliente logeado
            $cliente = Cliente::getClienteLogeado();
            $carrito = (Carrito::where('codCliente','=',$cliente->codCliente)->get())[0];


            $ListadetalleCarrito = Detalle_Carrito::where('codProducto','=',$idProducto)
            ->where('codCarrito','=',$carrito->codCarrito)->get();
            
        }
        if(count($ListadetalleCarrito)>0){
            $detalleCarrito = $ListadetalleCarrito[0];
            $detalleCarrito->delete();
        }

        return redirect()->route('carrito.mostrar')->with('datos','Elemento eliminado.');


    }


    public function mostrarCarrito()
    {
        date_default_timezone_set('America/Lima');
        if(is_null(Auth::user())){ //CARRITO ANON 
            //$ip=$_SERVER['REMOTE_ADDR'];
            //Recuperamos el token guardado anteriormente
            $token = session('token');
            if($token=='')
                return "NO HAY PRODUCTOS EN ESTE CARRITO ANON";
            

            $ListacarritoNON=CarritoAnon::where('codCarrito','=', $token)->get();
            $LISTAx = CarritoAnon::All();
            error_log('
            
            MIAU ----------------------------------------------- 
            MI TOKEN RECUPERADO = '.$token.'            
            
            
            
            '.$ListacarritoNON.'
            


            '.$LISTAx.'
            
            ');


            if(count($ListacarritoNON) > 0 ) //si hay algun carrito con ese token
                $carrito = $ListacarritoNON[0];
            else
            {
                $carrito=new CarritoAnon();
                $carrito->codCarrito=$token;
                $carrito->save();
            }
            $detalles=Detalle_CarritoAnon::where('codCarrito','=',$carrito->codCarrito)->get();
            $tipo=1;
        }
        else{           // CARRITO CON CLIENTE LOGEADO 
            $carritos=Carrito::where('codCliente','=',  Auth::user()->codCliente )->get();
            if(count($carritos) == 0 ){
                $carrito=new Carrito();
                $carrito->codCliente=Auth::user()->codCliente;
                $carrito->fechaHora=new DateTime();
                $carrito->save();
            }
            else{
                $carrito=$carritos[0];
            }
            $detalles=Detalle_Carrito::where('codCarrito','=',$carrito->codCarrito)->get();
            $tipo=2;
        }
        return view('cliente.MantenerCarrito.index',compact('carrito','detalles','tipo'));
    }
    








}
