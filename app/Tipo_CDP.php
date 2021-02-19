<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Throwable;

class Tipo_CDP extends Model
{
    protected $table = "TIPO_CDP";
    protected $primaryKey = "codTipo";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'nombre','serie','valor'
    ];


    public static function pasarASiguiente($tipo_id){
        try{
            $par = Tipo_CDP::findOrFail($tipo_id);

            //CASO EXTREMO SE ACABÓ LA NUMERACION
            if($par->valor == '999999'){
                $par->valor = '000000'; //cuando lo pase será 1
                $par->serie=$par->serie + 1;
            }

            $par->valor = $par->valor + 1;
            $par->save();

            return true;
        }catch(Throwable $ex){
            error_log('HA OCURRIDO UN ERROR EN Parametro::pasarASiguiente. Msj error:
            
            
            
            '.$ex.'
            
            
            
            
            ');
            return false;
            
        }
    }


    /* SI LE MANDAS 1 TE RETONA EL VALOR DE LA NUMERACION QUE ESTÁ LIBRE DE BOLETA
    SI 2 DE FACTURA */
    public static function getNumeracion($id){
        $tcdp = Tipo_CDP::findOrFail($id);
        return $tcdp; //OJO, TE RETORNA EL OBJETO, TIENES QUE SACAR DE ÉL LA SERIE Y EL VALOR
    }



}

