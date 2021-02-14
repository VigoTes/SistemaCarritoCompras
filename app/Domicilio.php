<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    protected $table = "DOMICILIO";
    protected $primaryKey = "codDomicilio";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'codCliente', 'direccion','codDistrito','codigoPostal','nroTelefonoFijo','esPrincipal','nombre'
    ];


    public function getDireccionCompleta(){
            $distrito = Distrito::findOrFail($this->codDistrito);
            $provincia  = Provincia::findOrFail($distrito->codProvincia);
            $region = Region::findOrFail($provincia->codRegion);
            $pais = Pais::findOrFail($region->codPais);

            return $this->direccion.' '.$distrito->nombre.', '.$provincia->nombre. ', '.$region->nombre.', '.$pais->nombre;

    }

    public function getPais(){
        $distrito = Distrito::findOrFail($this->codDistrito);
        $provincia  = Provincia::findOrFail($distrito->codProvincia);
        $region = Region::findOrFail($provincia->codRegion);
        $pais = Pais::findOrFail($region->codPais);
        return $pais;

    }
}
