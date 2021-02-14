<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cliente extends Model
{
    

    protected $table = "CLIENTE";
    protected $primaryKey = "codCliente";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'nombres', 'apellidos','nroTelefonoMovil'
    ];


    public static function getClienteLogeado(){
        $codUsuario = Auth::id();
        if($codUsuario!=''){
            $usuario = Usuario::findOrFail($codUsuario);
            $cliente = Cliente::findOrFail($usuario->codCliente);
            return $cliente;
        }   
        return 'No logeado';
    }


    public function getDireccionCompleta(){
        $ListaDomicilios = Domicilio::where('codCliente','=',$this->codCliente)
        ->where('esPrincipal','=','1')
        ->get();

        if(count($ListaDomicilios) > 0 )
        {
            $domicilioRetornado = $ListaDomicilios[0]; 
            $distrito = Distrito::findOrFail($domicilioRetornado->codDistrito);
            $provincia  = Provincia::findOrFail($distrito->codProvincia);
            $region = Region::findOrFail($provincia->codRegion);
            $pais = Pais::findOrFail($region->codPais);
            
            return $domicilioRetornado->direccion.' '.$distrito->nombre.', '.$provincia->nombre. ', '.$region->nombre.', '.$pais->nombre;
        }
        
        return 'No Configurado';


    }


}
