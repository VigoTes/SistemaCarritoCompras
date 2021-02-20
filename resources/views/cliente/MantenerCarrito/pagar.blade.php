@extends('layouts.master')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>

<script>
    let productos= [];
    let cantidades= [];
    let nuevaLongitud=[];
</script>

<style>
    .col{
        /* background-color: orange; */
        margin-top: 20px;
        margin-left: 25px;
    }
    .colLabel{
        width: 7%;
        /* background-color: aqua; */
        margin-top: 20px;    
        text-align: left;
        margin-left :0;
    }
    
    .colLabel2{
        width: 20%;
        /* background-color: #3c8dbc; */
        margin-top: 20px;
        text-align: left;
    }
    
</style>
<div class="container">
    <h1 class="text-center">REVISION FINAL DE LA ORDEN</h1>        

        


        <div class="col-md-12 pt-3">  
            <input id="codCarrito" type="hidden" name="codCarrito" value="{{ $carrito->codCarrito }}" >  
            <div class="table-responsive">                           
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th width="10" class="text-center">OPCIONES</th> 
                        <th>ARTICULO</th>                                       
                        <th class="text-center">CANTIDAD</th>                                 
                        <th  class="text-center">PRECIO UNITARIO</th>                                            
                        <th class="text-center">TOTAL</th>
                    </thead>
                    <tfoot>
                                                                                                        
                                                                                        
                    </tfoot>
                    <tbody>
                        <?php $total=0.0 ?>
                        @foreach($detalles as $itemdetalle)
                            <tr>
                                <script> 
                                    nuevaLongitud = productos.push('<?php echo $itemdetalle->codProducto?>'); 
                                    nuevaLongitud = cantidades.push('<?php echo $itemdetalle->cantidad?>');
                                </script>
                                <?php $importe=(float)$itemdetalle->producto->precioActual*(float)$itemdetalle->cantidad; $total+=$importe  ?>
                                <td style="text-align:center;">
                                    <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Eliminar registro" 
                                        onclick="swal(
                                                    {//sweetalert
                                                        title:'¿Está seguro de eliminar?',
                                                        text: '',     //mas texto
                                                        //type: 'warning',  
                                                        type: '',
                                                        showCancelButton: true,//para que se muestre el boton de cancelar
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText:  'SI',
                                                        cancelButtonText:  'NO',
                                                        closeOnConfirm:     true,//para mostrar el boton de confirmar
                                                        html : true
                                                    },
                                                    function()
                                                    {//se ejecuta cuando damos a aceptar
                                                        window.location.href='{{route('carrito.eliminarProducto',$itemdetalle->codProducto)}}';
                                                    }
                                                    );">
                                        <i class="entypo-cancel"></i>  
                                        <i class="fas fa-trash"></i>
                                        
                                    </a>


                                </td>
                                <td>{{$itemdetalle->producto->nombre}}</td>
                                <td style="text-align:right;"><input type="number" name="cantidad[]" id="cantidad{{$itemdetalle->codDetCarrito}}" min="1" onchange="cambioCantidad({{$itemdetalle->codDetCarrito}},{{$itemdetalle->codProducto}})"  value="{{$itemdetalle->cantidad}}" style="width:80px; text-align:right;"></td>
                                <td style="text-align:right;"><input type="number" name="pventa[]" id="pventa{{$itemdetalle->codDetCarrito}}" value="{{$itemdetalle->producto->precioActual}}" style="width:80px; text-align:right;" readonly></td>
                                <td style="text-align:right;">S/ <input type="number" name="importe[]" id="importe{{$itemdetalle->codDetCarrito}}" value="{{$importe}}" style="width:80px; text-align:right;" readonly></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> 
                <div class="row">                       
                    <div class="col-md-8">
                    </div>   
                    <div class="col-md-2">                        
                        <label for="">Sub Total : </label>    
                    </div>   
                    <div class="col-md-2">
                        <input type="number" class="form-control text-right" name="total" id="total" readonly="readonly" value="{{$total}}">                              
                    </div>   
                </div>
            
        </div> 

    <hr>
    <h1 class="text-center">REVISIÓN DE CARGA A LA CUENTA Y ENTREGA</h1>
    <p >Revise que su informacion sea correcta</p>
    <form method="POST" action="{{route('carrito.registrarCompra')}}" onsubmit="return validarCampos()" id="frmRegistrado" name="frmRegistrado">
        @csrf
        <div class="container">
            <div style="margin-left:100px;">
                <strong>Entregar a:</strong>
                {{$cliente->apellidos}}, {{$cliente->nombres}} ({{$cliente->nroTelefonoMovil}})<br>
                <div class="row">
                    @foreach( $listaDomicilios as $itemdomicilio)
                    <div class="form-check col-sm-3">
                        <input class="form-check-input" type="radio" name="radio1" 
                            id="val{{$itemdomicilio->codDomicilio}}" value="{{$itemdomicilio->codDomicilio}}">
                        <label class="form-check-label" for="val{{$itemdomicilio->codDomicilio}}">
                            {{$itemdomicilio->getDireccionCompleta()}}
                        </label>
                    </div>
                    @endforeach
                </div>
                <br>
            </div>
            <div class="form-group row" >
                <div class="container">
                    <div class="row">
                        <div class="colLabel" style="">
                            <label class="col-sm-1 col-form-label" >Comprobante:</label>
                        </div>
                        <div class="col" >
                            <select class="form-control" name="tipoCDP" id="tipoCDP" onchange="cambioCDP()">
                                <option value="0">--Seleccionar--</option>
                                @foreach($tiposCDP as $itemtipo)
                                <option value="{{$itemtipo->codTipo}}">{{$itemtipo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="colLabel">
                            <label class="col-sm-1 col-form-label">Nro:</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="nroCDP" name="nroCDP" placeholder="" readonly >
                        </div>
                        <div class="colLabel">
                            <label class="col-sm-1 col-form-label" >Metodo:</label>

                        </div>

                        <div class="col">
                            <select class="form-control" name="codMetodo" id="codMetodo">
                                <option value="0">--Seleccionar--</option>
                                @foreach($metodos as $itemmetodo)
                                <option value="{{$itemmetodo->codMetodo}}">{{$itemmetodo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="colLabel">
                            <label class="col-sm-1 col-form-label">Tarjeta:</label>

                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="tarjeta" name="tarjeta" placeholder="Tarjeta..." >

                        </div>
                        
                    </div>

                </div>




            </div>
        </div>
    </form>
    
    <div class="col-md-12 text-center">  
        <input type="button"  class="btn btn-primary" id="boton" value="Registrar">          
    </div>
    <br>

<script>
    cont=0;

    $(document).ready(function(){
		$("#boton").click(function () {
            //cont=0;
            //alert('GAAAAAAAAAAA');
            i =0;
            productos.forEach(function(codProducto, index) {
                //alert(val+'...'+cantidades[index]);
                //sppWizard.init(optionsAssistant);
                cont=0;
                $.get('/verificarStock/'+codProducto, function(data){
                    cantidadProducto=data;
                    console.log('aaaaaaaaa'+data);

                    if(parseInt(cantidadProducto)<parseInt(cantidades[index])){
                        alert('stock insuficiente para producto (Nrº: '+index+')');
                        cont+=1;
                    }else{
                        //alert('stock suficiente para producto (cod: '+codProducto+')');
                        
                    }

                    
                    i = index;
                    console.log('prod lengt'+productos.length + '   i='+i)
                    //ultima ejecucion
                    if(i == productos.length-1){
                        
                        //alert('ya acabo');
                        if(cont==0){
                            $("#frmRegistrado").submit();
                        }

                    }

                });
                
            });
            
           

			//codDomicilio=$('input:radio[name=radio1]:checked').val();
            //alert('ahora va a cambiar');
            //$("#frmRegistrado").submit();
		});
    });

    function verificar(){
        alert('ASSASASASA');
        
        productos.forEach(function(codProducto, index) {
                //alert(val+'...'+cantidades[index]);
                $.get('/verificarStock/'+codProducto, function(data){
                    cantidadProducto=data;
                    
                    if( parseInt(cantidadProducto)< parseInt(cantidades[index] )){
                        alert('stock insuficiente para producto (cod: '+codProducto+')');
                        
                    }else{
                        alert('stock suficiente para producto (cod: '+codProducto+')');
                        cont+=1;
                    }
                    
                });
                
            });
    }

    function cambioCantidad(codigo, codigoProducto){
        importeAnterior=$('#importe'+codigo).val();
        precioVenta=$('#pventa'+codigo).val();
        cantidadActual=$('#cantidad'+codigo).val();

        if(cantidadActual<1){
            cantidadActual=1;
            $('#cantidad'+codigo).val(1);
        }

        codCarrito=$('#codCarrito').val();
        //cambiamos la cantidad en bd
        $.get('/cambiarCantidadProducto/'+2+'*'+codCarrito+'*'+codigo+'*'+cantidadActual, function(data){});

        //cambiar valor en la verificacion
        productos.forEach(function(val, index) {
            if(val==codigoProducto){
                cantidades[index]=cantidadActual;
            }
        }
        );
        
        importeActual=cantidadActual*precioVenta;

        totalAnterior=$('#total').val();
        totalActual=totalAnterior-importeAnterior+importeActual; 

        $('#importe'+codigo).val(importeActual);
        $('#total').val(totalActual);
    }

    function cambioCDP(){
        var x = document.getElementById("divNroSerie");

        if( $('#tipoCDP').val() == '0')
        {
          $('#nroSerie').val('');
          return false;
        }
        $.get('/obtenerParametros/'+$('#tipoCDP').val(), function(data)
            {     
              $('#nroCDP').val(llenarConCeros(data.serie,3)+'-'+llenarConCeros(data.valor,6));
              console.log(data);
            } 
        );


    }

    function llenarConCeros(value, length) {
      return (value.toString().length < length) ? llenarConCeros("0" + value, length) : value;
    }
    function validarCampos(){
        msj='';
        codCDP = $('#codTipo').val();
        if(codCDP=='0'){
            msj = 'Ingrese un tipo de comprobante de pago.';

        }


        codMetodo = $('#codMetodo').val();
        if(codMetodo=='0'){
            msj = 'Ingrese un metodo de pago.';
            
        }
        
        
        tarjeta = $('#tarjeta').val();
        if(tarjeta==''){
            msj = 'Ingrese una tarjeta de credito.';
            
        }

        
        tr = document.querySelector('input[name="radio1"]:checked')
        if(tr==null)
            msj='Seleccione un domicilio.';


        if(msj!='')
            {
                alert(msj);
                return false;

            }
        return true;

    }
</script>



@endsection