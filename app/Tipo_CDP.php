<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_CDP extends Model
{
    protected $table = "TIPO_CDP";
    protected $primaryKey = "codTipo";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'nombre','serie','valor'
    ];

    /* SI LE MANDAS 1 TE RETONA EL VALOR DE LA NUMERACION QUE ESTÁ LIBRE DE BOLETA
    SI 2 DE FACTURA */
    public function getNumeracion($id){
        $tcdp = Tipo_CDP::findOrFail($id);
        return $tcdp; //OJO, TE RETORNA EL OBJETO, TIENES QUE SACAR DE ÉL LA SERIE Y EL VALOR
    }
}
