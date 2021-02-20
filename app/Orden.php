<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = "ORDEN";
    protected $primaryKey = "codOrden";
    public $timestamps = false;  //para que no trabaje con los campos fecha 


    protected $fillable = [
        'codMetodo', 'total','codDomicilio','codCliente','codCliente'
        ,'fechaHoraVenta','codTipo','totalIGV','codEstado','nroCDP','razonCancelacion'
    ];


    public function getNombreEstado(){
        $estado = Estado_Orden::findOrFail($this->codEstado);
        return $estado->nombre;
    }

    
    public function getNombreEstadoSiguiente(){
        $estado = Estado_Orden::findOrFail($this->codEstado+1);
        return $estado->nombre;
    }

    public function getColorEstado(){ //BACKGROUND
        $color = '';
        switch($this->codEstado){
            case '1': //CREADO
                $color = 'rgb(215,208,239)';
                break;
            case '2': //procesado
                $color = 'rgb(91,79,148)';
                break;
            case '3': //enviado
                $color = 'rgb(195,186,230)';
                break;
            case '4': //entregada
                $color ='rgb(35,28,85)';
                break;
            case '5': //cancelada
                $color = 'rgb(238,108,77)';
                break;
            
        }
        return $color;
    }

    public function getColorLetrasEstado(){
        $color = '';
        switch($this->codEstado){
            case '1': //CREADO
                $color = 'black';
                break;
            case '2': //procesado
                $color = 'white';
                break;
            case '3': //enviado
                $color = 'black';
                break;
            case '4': //entregada
                $color = 'white';
                break;
            case '5': //cancelada
                $color = 'white';
                break;
            
        }
        return $color;
    }

    public function getFecha(){
        $fecha = $this->fechaHoraVenta;
        $fecha = substr($fecha,0,10);

        $fecha = str_replace('-','/',$fecha);
        return $fecha;
    }
    public function getHora(){
        $fecha = $this->fechaHoraVenta;
        $fecha = substr($fecha,10,9);
        
        $fecha = str_replace('-','/',$fecha);
        return $fecha;

    }

    public function getFechaHora(){
        $fecha = $this->fechaHoraVenta;
        $fecha = substr($fecha,0,19);

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
        error_log('
        
        '.$dom->nombre.'
        
        
        
        ');
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

    public function cliente(){
        $cliente=Cliente::find($this->codCliente);
        return $cliente;
    }
}
