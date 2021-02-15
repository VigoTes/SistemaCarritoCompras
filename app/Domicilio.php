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

    public function getRegion(){
        $distrito = Distrito::findOrFail($this->codDistrito);
        $provincia  = Provincia::findOrFail($distrito->codProvincia);
        $region = Region::findOrFail($provincia->codRegion);
        return $region;

    }

    public function getProvincia(){
        $distrito = Distrito::findOrFail($this->codDistrito);
        $provincia  = Provincia::findOrFail($distrito->codProvincia);
        return $provincia;

    }

    //metodo para setear este domicilio como el principal de este cliente
    public function setPrincipal(){
        $listaDomiciliosDelCliente = Domicilio::where('codCliente','=',$this->codCliente)->get();

        //quitamos el esPrincipal de todos los domicilios de ese cliente
        foreach ($listaDomiciliosDelCliente as $itemDom) {
            $itemDom->esPrincipal='0';
            $itemDom->save();
        }

        $this->esPrincipal='1';

    }

    public function distrito(){
        return $this->hasOne('App\Distrito','codDistrito','codDistrito');
    }


}
