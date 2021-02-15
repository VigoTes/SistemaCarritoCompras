<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = "ORDEN";
    protected $primaryKey = "codOrden";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'codMetodo', 'total','codDomicilio','codCliente','codCliente','fechaHoraVenta','codTipo','totalIGV','codEstado'
    ];


    public function getFecha(){
        $fecha = $this->fechaHoraVenta;
        $fecha = substr($fecha,0,10);

        $fecha = str_replace('-','/',$fecha);
        return $fecha;
    }


    public function getResumen(){
        $codOrden = $this->codOrden;
        $listaDetalles = Detalle_Orden::where('codOrden','=',$codOrden)->get();

        $resumen ='';
        for ($i=0; $i < count($listaDetalles); $i++) { 
            $prod = Producto::findOrFail($listaDetalles[$i]->codProducto);

            $resumen = $resumen.($prod->nombre).',';
        }

        $resumen = trim($resumen,',');
        return $resumen;
    }

    public function getDomicilio(){
        $dom = Domicilio::findOrFail($this->codDomicilio);
        return $dom;
    }

    public function getTipoCDP(){
        $cdp = Tipo_CDP::findOrFAIL($this->codTipo);
        return $cdp->nombre;
        
    }

    public function getEstado(){
        $estado = Estado_Orden::findOrFail($this->codEstado);   
        return $estado->nombre;

    }
}
