<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;
use Illuminate\Support\Facades\Auth;
class Usuario extends Model
{


    protected $table = "USUARIO";
    protected $primaryKey = "codUsuario";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'codCliente', 'email','password','fechaActualizacion','isAdmin'
    ];


    /* FUNCIONES PARA VER EL CARRITO DESDE EL PLANTILLA  */

    //Retorna los detallesCarrito del carrito que tengo, sea usuario anonimo o logeado
    public static function getdetallesCarrito(){ 
        if(is_null(Auth::user())){ //CARRITO ANON 
            //Recuperamos el token guardado anteriormente
            $token = session('token');
            $detallesCarrito=Detalle_CarritoAnon::where('codCarrito','=',$token)->get();
        }
        else{           // CARRITO CON CLIENTE LOGEADO 
            $carritos=Carrito::where('codCliente','=',  Auth::user()->codCliente )->get(); //vemos si tiene un carrito
            if(count($carritos) > 0 ){
                $carrito = $carritos[0];
                $detallesCarrito=Detalle_Carrito::where('codCarrito','=',$carrito->codCarrito)->get();
            }else
                $detallesCarrito=[];   
        }
        return $detallesCarrito;

    } 

    public static function getNroDetallesCarrito(){
        return count(Usuario::getdetallesCarrito());

    }


    public static function getEmailPorCodUsuario($codUsuario){
        if($codUsuario=='')
            return 'No logeado';
            
 
        $usuario = Usuario::findOrFail($codUsuario);
        return $usuario->email;
        
    
    }

    public static function getClientePorCodUsuario($codUsuario){
        $usuario = Usuario::findOrFail($codUsuario);
        $cliente = Cliente::findOrFail($usuario->codCliente);
        return $cliente;
    }
    public function cliente(){
        return $this->hasOne('App\Cliente','codCliente','codCliente');
    }

}
