<!DOCTYPE html>
<html lang="en">
<head>
    <title> {{($tipo==2)? 'FACTURA' : 'BOLETA'}} N {{$orden->nroCDP}}</title>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        html {
            /* Arriba | Derecha | Abajo | Izquierda */
            margin: 12pt 15pt 0 15pt;
            font-family: Courier;
        }

        #principal { 
            /*background-color: rgb(161, 51, 51);*/
            word-wrap: break-word;/* para que el texto no salga del div*/
        }
        p {
            margin-top: 3px;
            margin-bottom: 3px;
        }
        
    </style>
</head>
<body>
    <div id="principal" style="width: 365px; height: 200px;">
        <p style="text-align: center; font-size: 15pt; text-transform: uppercase;"><b>{{($tipo==2)? 'FACTURA' : 'BOLETA'}} Nº:{{$orden->nroCDP}}</b></p>
        <p style="text-align: center; font-size: 8pt;">Iquitos 208 - Aranjuez<br> Ruc: 14725896315</p>
        <p style="text-align: center; font-size: 8pt;">ISO Carrito</p>
        <p style="text-align: center; font-size: 11pt;">-----------------------------------------</p>
        <p style="font-size: 8pt;"><b>Nº DE Orden:</b> {{$orden->codOrden}}</p>
        <p style="font-size: 8pt;"><b>FECHA DE VENTA:</b> {{$orden->fechaHoraVenta}}</p>
        <p style="font-size: 8pt;"><b>FECHA DE IMPRESION:</b> {{$fechaHora->format("Y-m-d H:i:s")}}</p>
        <p style="text-align: center; font-size: 11pt;">---------------- <b>CLIENTE</b> ----------------</p>
        <p style="font-size: 8pt;"><b>CLIENTE:</b> {{$orden->cliente()->apellidos}}, {{$orden->cliente()->nombres}}</p>
        <p style="font-size: 8pt;"><b>DIRECCION:</b> {{$domicilio->direccion}}</p>
        <p style="font-size: 8pt;"><b>CODIGO POSTAL:</b> {{$domicilio->codigoPostal}}</p>
        <p style="text-align: center; font-size: 11pt;">--------------- <b>PRODUCTOS</b> ---------------</p> 
    </div>
    <div id="principal" style="width: 365px; height: 30px;">
        <div style="width: 13%; height: 30px; float: left;">
            <p style="text-align: center; font-size: 10pt;"><b>CANT</b></p>
            <p style="text-align: center; font-size: 11pt;">-----</p>
        </div>
        <div style="width: 47%; height: 30px; float: left;">
            <p style="text-align: center; font-size: 10pt;"><b>DESCRIPCION</b></p>
            <p style="text-align: center; font-size: 11pt;">-------------------</p>
        </div>
        <div style="width: 20%; height: 30px; float: left;">
            <p style="text-align: center; font-size: 10pt;"><b>PRECIO</b></p>
            <p style="text-align: center; font-size: 11pt;">--------</p>
        </div>
        <div style="width: 20%; height: 30px; float: left;">
            <p style="text-align: center; font-size: 10pt;"><b>IMPORTE</b></p>
            <p style="text-align: center; font-size: 11pt;">--------</p>
        </div>
    </div>

    <!--  ES UNO POR CADA PROFUCTO -->
    @foreach($detalles as $itemdetalle)
        <?php $importe=(float)$itemdetalle->cantidad*(float)$itemdetalle->precio ?>
        <p style="margin: 1px"></p>
        <div id="principal" style="width: 365px; height: {{round(strlen($itemdetalle->producto->nombre)/(float)24, 0, PHP_ROUND_HALF_UP)*10+20}}px;">
            <div style="width: 13%; height: 20px; background-color: white; float: left;">
                <p style="text-align: center; font-size: 8pt;">{{$itemdetalle->cantidad}}.00</p>
            </div>
            <div style="width: 47%; height: 20px; background-color: white; float: left;">
                <p style="text-align: center; font-size: 8pt;">{{$itemdetalle->producto->nombre}}</p>
            </div>
            <div style="width: 20%; height: 20px; background-color: white; float: left;">
                <p style="text-align: center; font-size: 8pt;">S/ {{number_format($itemdetalle->precio,2)}}</p>
            </div>
            <div style="width: 20%; height: 20px; background-color: white; float: left;">
                <p style="text-align: center; font-size: 8pt;">S/ {{number_format($importe,2)}}</p>
            </div>
        </div>
    @endforeach
    <!-- HASTA AQUI :v-->

    <div id="principal" style="width: 365px; height: 12px;">
        <p style="text-align: center; font-size: 11pt;">----------------- <b>PAGO</b> -----------------</p> 
    </div>
    <!--
    <p style="margin: 1px"></p>
    <div id="principal" style="width: 365px; height: 15px;">
        <div style="width: 50%; height: 15px; float: left;">
            <p style="font-size: 10pt; text-align: right;"><b>SUBTOTAL IGV 0%:</b></p>
        </div>
        <div style="width: 50%; height: 15px; float: left;">
            <p style="font-size: 10pt; text-align: right;">S/ 0.00</p>
        </div>
    </div>
    -->
    @if($tipo==2)
    <p style="margin: 1px"></p>
    <div id="principal" style="width: 365px; height: 15px;">
        <div style="width: 50%; height: 15px; float: left;">
            <?php $subtotal=(float)$orden->total/1.18 ?>
            <p style="font-size: 10pt; text-align: right;"><b>SUBTOTAL:</b></p>
        </div>
        <div style="width: 50%; height: 15px;float: left;">
            <p style="font-size: 10pt; text-align: right;">S/ {{number_format($subtotal,2)}}</p>
        </div>
    </div>
    <p style="margin: 1px"></p>
    <div id="principal" style="width: 365px; height: 15px;">
        <div style="width: 50%; height: 15px; float: left;">
            <?php $igv=(float)$orden->total-$subtotal ?>
            <p style="font-size: 10pt; text-align: right;"><b>IGV:</b></p>
        </div>
        <div style="width: 50%; height: 15px; float: left;">
            <p style="font-size: 10pt; text-align: right;">S/ {{number_format($igv,2)}}</p>
        </div>
    </div>
    @endif
    
    <p style="margin: 1px"></p>
    <div id="principal" style="width: 365px; height: 15px;">
        <div style="width: 50%; height: 15px; float: left;">
            <p style="font-size: 10pt; text-align: right;"><b>TOTAL A PAGAR:</b></p>
        </div>
        <div style="width: 50%; height: 15px; float: left;">
            <p style="font-size: 10pt; text-align: right;">S/ {{number_format($orden->total,2)}}</p>
        </div>
    </div>
    <div id="principal" style="width: 365px; height: 20px;">
        
    </div>
    <div id="principal" style="width: 365px; height: 19px;">
        <p style="text-align: center; font-size: 11pt;">#########################################</p>
    </div>
    <div id="principal" style="width: 365px; height: 19px;">
        <p style="text-align: center; font-size: 11pt;"><i><b>GRACIAS POR SU COMPRA <\3</b><i></p>
    </div>
</body>

</html>