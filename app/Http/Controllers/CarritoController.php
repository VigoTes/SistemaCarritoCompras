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
use App\Detalle_Orden;
use App\Metodo_Pago;
use App\Orden;
use App\Producto;
use App\Tipo_CDP;

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


    public function mostrarCarrito(){
        date_default_timezone_set('America/Lima');
        if(is_null(Auth::user())){ //CARRITO ANON 
            //$ip=$_SERVER['REMOTE_ADDR'];
            //Recuperamos el token guardado anteriormente
            $token = session('token');
            if($token=='')
            {
                $ListacarritoNON=[];
            }else{
                $ListacarritoNON=CarritoAnon::where('codCarrito','=', $token)->get();
            }
            $LISTAx = CarritoAnon::All();
            


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

    public function cambiarCantidad($id){

        try {
            /* 
            0   si es anon o normal
            1   codCarrito
            2   codigo del detalle
            3   cantidad
            
            */
        
            $arr = explode('*', $id);
            if($arr[0]==1){
                
                //return $arr[1];
                $Listacarrito = CarritoAnon::where('codCarrito','=',$arr[1])->get();          
                $carrito = $Listacarrito[0];

                $detalle=Detalle_CarritoAnon::find($arr[2]);

            }
            

            if($arr[0]==2){
                $carrito=Carrito::find($arr[1]);
                $detalle=Detalle_Carrito::find($arr[2]);
               
            }
            
            
            //return $detalle;
            $detalle->cantidad=(int)$arr[3]; //AQUI 
          
            //return "yala";
            $detalle->save();

            $estado='ok';
            error_log('---------------- CAMBIANDO CANTIDAD DESDE EL CARRITO');
            return $estado;

        } catch (\Throwable $th) {
        error_log('CAMBIAR CANTIDAD-------- '.$id.'
            
            ------------ ERROR: 
        
        
        '.$th);

        }
   
    }


   
    public function menuOpcionesCaja(){
        return view('cliente.MantenerCarrito.opcionesCaja');
    }

    public function mostrarReporte(){
        $carritos=Carrito::where('codCliente','=',  Auth::user()->codCliente )->get();
        $carrito=$carritos[0];
        $detalles=Detalle_Carrito::where('codCarrito','=',$carrito->codCarrito)->get();
        $tiposCDP=Tipo_CDP::all();
        $metodos=Metodo_Pago::all();
        return view('cliente.MantenerCarrito.reporte',compact('carrito','detalles','tiposCDP','metodos'));
    }

    public function registrarCompra(Request $request)
    {
        date_default_timezone_set('America/Lima');

        $orden=new Orden();
        $orden->codMetodo=$request->codMetodo;
        $orden->codDomicilio=$request->radio1;
        $orden->codCliente=Auth::user()->codCliente;
        $orden->fechaHoraVenta=new DateTime();
        $orden->codTipo=$request->codTipo;
        $orden->codEstado='1';
        

        $total=0;
        $carritos=Carrito::where('codCliente','=',  Auth::user()->codCliente )->get();
        $carrito=$carritos[0];
        $detalles=Detalle_Carrito::where('codCarrito','=',$carrito->codCarrito)->get();
        foreach ($detalles as $itemdetalle) {
            $total+=$itemdetalle->producto->precioActual*$itemdetalle->cantidad;
        }

        $orden->total=$total;
        $orden->totalIGV=(float)$total*1.18;
        $orden->save();

        foreach ($detalles as $itemdetalle) {
            $detalle=new Detalle_Orden();
            $detalle->codProducto=$itemdetalle->codProducto;
            $detalle->codOrden=$orden->codOrden;
            $detalle->precio=$itemdetalle->producto->precioActual;
            $detalle->cantidad=$itemdetalle->cantidad;
            $detalle->save();

            //actualizar stock
            $productoTemp=Producto::find($itemdetalle->codProducto);
            $productoTemp->stock-=$itemdetalle->cantidad;
            $productoTemp->save();

            $itemdetalle->delete();
        }

        //obtenemos la orden redien creada
        $codOrdenCreada= (Orden::latest('codOrden')->first())->codOrden;
			

        return redirect()->route('orden.listar',$orden->codCliente)->with('datos','Orden N°'.$codOrdenCreada.' Registrada!');
    }


}
