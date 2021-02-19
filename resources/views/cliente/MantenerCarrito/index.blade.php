@extends('layouts.master')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>

<div class="container">
    <h1 class="text-center">CARRITO DE COMPRAS</h1>        
    <div class="alert  hidden" role="alert"></div>


    @if(session('datos'))<!-- cuando se registra algo-->
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                {{session('datos')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>    
    @endif

    <form method="POST" action="">
    @csrf
   {{--  {{$tipo}} --}}

   


    <div class="col-md-12 pt-3">  
        <input id="tipo" type="hidden" name="tipo" value="{{ $tipo }}" >
        <input id="codCarrito" type="hidden" name="codCarrito" value="{{ $carrito->codCarrito }}" >  
        <div class="table-responsive">                           
            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                <thead class="thead-default" style="background-color:#5B4F94;color: #fff;">
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

    <div class="col-md-12 text-center">  
        <div  id="guardar">
            <div class="form-group">
                <a href="" class="btn btn-primary" id="btnPagar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                    <i class='fas fa-save'></i> Pagar</a>    
                    

                <a href="#" class="btn btn-danger" title="Eliminar registro" 
                    onclick="swal(
                                {//sweetalert
                                    title:'¿Está seguro de limpiar el carrito? Esto eliminará todos los items del carrito.',
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
                                    window.location.href='{{route('carrito.limpiar')}}';
                                
                                }
                                );">
                    <i class="entypo-cancel"></i>  
                    <i class='fas fa-ban'></i>
                    Limpiar Carrito
                </a>
                
                            
            </div>    
        </div>
    </div>
    </form>


<script>
$(document).ready(function(){
		$("#btnPagar").click(function () {
            estaLogueado=0;
            $.get('/verificarLogin', function(data){
                estaLogueado=data;
                if(estaLogueado==1){
                    window.location.href="{{route('carrito.verPagar')}}";
                }else{
                    window.location.href="{{route('carrito.verOpcionesPagoAnonimo')}}";
                }
            });
            //alert(estaLogueado);
            //window.location.href='/mostrarReporte';
            /*
            if(estaLogueado==1){
                window.location.href='/mostrarReporte';
            }else{
                window.location.href='/menuOpcionesCaja';
            }
            */
		});
});

    function cambioCantidad(codDetalleCarrito,codProducto){
        importeAnterior=$('#importe'+codDetalleCarrito).val();
        precioVenta=$('#pventa'+codDetalleCarrito).val();
        cantidadActual=$('#cantidad'+codDetalleCarrito).val();
        if(cantidadActual<1){
            cantidadActual=1;
            $('#cantidad'+codDetalleCarrito).val(1);
        }
        tipoCarrito=$('#tipo').val();
        codCarrito=$('#codCarrito').val();

        $.get('/verificarStock/'+codProducto, function(data){
            cantidadProducto=parseInt(data);
            cantidadMarcada= parseInt(cantidadActual);
            //VERIFICAMOS EL STOCK PRIMERO
            if(cantidadProducto < cantidadMarcada){
                alert('Stock insuficiente, solo se dispone de '+cantidadProducto+' unidades');
                $('#cantidad'+codDetalleCarrito).val(cantidadProducto);

            }else{   
                //cambiamos la cantidad en bd
                $.get('/cambiarCantidadProducto/'+tipoCarrito+'*'+codCarrito+'*'+codDetalleCarrito+'*'+cantidadActual, function(data){});
                importeActual=cantidadActual*precioVenta;

                totalAnterior=$('#total').val();
                totalActual=totalAnterior-importeAnterior+importeActual; 

                $('#importe'+codDetalleCarrito).val(importeActual);
                $('#total').val(totalActual);
            }


        });

    }
</script>



@endsection