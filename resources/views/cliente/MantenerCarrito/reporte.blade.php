@extends('layouts.master')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>

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
                                <td style="text-align:right;"><input type="number" name="cantidad[]" id="cantidad{{$itemdetalle->codDetCarrito}}" min="1" onchange="cambioCantidad({{$itemdetalle->codDetCarrito}})"  value="{{$itemdetalle->cantidad}}" style="width:80px; text-align:right;"></td>
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
    <h1 class="text-center">REVISION DE CARGA A LA CUENTA Y ENTREGA</h1>
    <p >Revise que su informacion sea correcta</p>
    <form method="POST" action="/registrarCompra" id="frmRegistrado" name="frmRegistrado">
        @csrf
        <div class="container">
            <div style="margin-left:100px;">
                <strong>Entregar a:</strong>
                {{Auth::user()->usuario->cliente->apellidos}}, {{Auth::user()->usuario->cliente->nombres}} ({{Auth::user()->usuario->cliente->nroTelefonoMovil}})<br>
                <div class="row">
                    @foreach(Auth::user()->usuario->cliente->domicilio as $itemdomicilio)
                    <div class="form-check col-sm-3">
                        <input class="form-check-input" type="radio" name="radio1" id="val{{$itemdomicilio->codDomicilio}}" value="{{$itemdomicilio->codDomicilio}}">
                        <label class="form-check-label">
                            {{$itemdomicilio->direccion}} ({{$itemdomicilio->nroTelefonoFijo}})<br>
                            {{$itemdomicilio->codigoPostal}} <br>
                            {{$itemdomicilio->distrito->nombre}} <br>
                            {{$itemdomicilio->distrito->provincia->nombre}} <br>
                            {{$itemdomicilio->distrito->provincia->region->nombre}} <br>
                            {{$itemdomicilio->distrito->provincia->region->pais->nombre}} <br>
                        </label>
                    </div>
                    @endforeach
                </div>
                <br>
            </div>
            <div class="form-group row" >
                <label class="col-sm-1 col-form-label" >CDP:</label>
                <div class="col-sm-3">
                    <select class="form-control" name="codTipo" id="codTipo">
                    <option value="0">--Seleccionar--</option>
                    @foreach($tiposCDP as $itemtipo)
                    <option value="{{$itemtipo->codTipo}}">{{$itemtipo->nombre}}</option>
                    @endforeach
                    </select>
                </div>
                <label class="col-sm-1 col-form-label" >Metodo:</label>
                <div class="col-sm-3">
                    <select class="form-control" name="codMetodo" id="codMetodo">
                    <option value="0">--Seleccionar--</option>
                    @foreach($metodos as $itemmetodo)
                    <option value="{{$itemmetodo->codMetodo}}">{{$itemmetodo->nombre}}</option>
                    @endforeach
                    </select>
                </div>
                <label class="col-sm-1 col-form-label">Tarjeta:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="tarjeta" name="tarjeta" placeholder="Tarjeta..." >
                </div>
            </div>
        </div>
    </form>
    
    <div class="col-md-12 text-center">  
        <input type="button"  class="btn btn-primary" id="boton" value="Registrar">          
    </div>
    <br>

<script>
    $(document).ready(function(){
		$("#boton").click(function () { 
			codDomicilio=$('input:radio[name=radio1]:checked').val();
            alert('ahora va a cambiar');
            $("#frmRegistrado").submit();
		});
    });

    function cambioCantidad(codigo){
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
        
        importeActual=cantidadActual*precioVenta;

        totalAnterior=$('#total').val();
        totalActual=totalAnterior-importeAnterior+importeActual; 

        $('#importe'+codigo).val(importeActual);
        $('#total').val(totalActual);
    }
</script>



@endsection