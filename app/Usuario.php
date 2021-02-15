<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;

class Usuario extends Model
{


    protected $table = "USUARIO";
    protected $primaryKey = "codUsuario";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'codCliente', 'email','password','fechaActualizacion','isAdmin'
    ];


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
