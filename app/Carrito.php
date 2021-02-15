<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Carrito extends Model
{
    protected $table = "CARRITO";
    protected $primaryKey = "codCarrito";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'codCliente', 'fechaHora'
    ];

    
    //se ejecuta cuando estaba agregando items a mi carrito de manera anonima, y le doy a pagar y me logeo.
    //lo que hace es sumar los detalles de mi carrito anon a mi carrito logeado normal 
    public static function sumarCarritoAnonAlCarritoLogin($email){
        //encontramos al usuario
        $user = Usuario::where('email','=',$email)->first();
        
        //encontramos al cliente
        $cliente = Cliente::findOrFail($user->codCliente);

        //verificamos si tiene un carrito activo
        $listaCarritos = Carrito::where('codCliente','=',$cliente->codCliente)->get();
        $codCarritoAnon = session('token');
        
        $carritoAnon = CarritoAnon::where('codCarrito','=',$codCarritoAnon)->first();
        if(count($listaCarritos)>0) //ya tiene un carrito creado, hay que sumar 
        {
            $carrito = $listaCarritos[0];
            
        }
        else
        { //no tiene un carrito, hay que setear
            //Creamos el carrito
            $carrito = new Carrito();
            $carrito->codCliente = $cliente->codCliente;
            $carrito->fechaHora = Carbon::now()->subHours(5);
            $carrito->save();
            
        }
        $carrito = Carrito::where('codCliente','=',$cliente->codCliente)->first(); //obtenemos el carrito que acabamos de crear

        $detallesCarritoAnon = Detalle_CarritoAnon::where('codCarrito','=',$codCarritoAnon)->get();
        //Recorremos los detalles del carrito anon y los añadimos al carrito que tenemos actualmente LOGEADO
        for ($i=0; $i < count($detallesCarritoAnon); $i++) { 
            $detalleAnon = $detallesCarritoAnon[$i];

            $detalle = new Detalle_Carrito();
            $detalle->cantidad = $detalleAnon->cantidad;
            $detalle->codProducto = $detalleAnon->codProducto;

            $detalle->codCarrito = $carrito->codCarrito; //aqui si ponemos el del carrito del user logeado
            
            $detalle->save();
            $detalleAnon->delete();

            
        }
        $carritoAnon->delete(); //borramos ese carrito anon (liberamos ese token de la BD)

    } 
}
