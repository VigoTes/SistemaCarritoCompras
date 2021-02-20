@extends('layouts.master')

@section('content')
<script> 
    function alerta( x )
        {
        var mensaje;
        var opcion = confirm("Clicka en Aceptar o Cancelar");
        if (opcion == true) {
            alert('OK'+x);
        } else {
            //mensaje = "Has clickado Cancelar";
        }
        //document.getElementById("ejemplo").innerHTML = mensaje;
    }
</script>

<style>
    .col{
        /* background-color: orange; */
        margin-top: 20px;
        
    }
    .colLabel{
        width: 10%;
        /* background-color: aqua; */
        margin-top: 23px;    
        text-align: left;
        margin-left: 10px;
    }
    
    .colLabel2{
        width: 20%;
        /* background-color: #3c8dbc; */
        margin-top: 20px;
        text-align: left;
    }
    
</style>

    <div style="margin-bottom:25px;">
        <h3>Detalles de la orden</h3>
    
        
        @if(session('datos'))<!-- cuando se registra algo-->
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                {{session('datos')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>    
        @endif
    </div>

    <div class="container" style="margin-bottom: 30px;">      
        <div class="row">
            <div  class="colLabel">
                <label for="fecha">Nombre:</label>
            </div>
            <div class="col">                  
                <div class="input-group date form_date " style="" >
                    <input type="text"  class="form-control" name="nombre" id="nombre" readonly
                        value="{{App\Cliente::getClienteLogeado()->nombres.' '.App\Cliente::getClienteLogeado()->apellidos}}" >     
                </div>
            </div>

            <div class="colLabel"> 
                <label for="">Dirección</label>
            </div>

            <div class="col">
                <input type="text" class="form-control" value="{{ $domicilioDestino->getDireccionCompleta() }}" readonly>
            </div>
           
            <div class="w-100"></div> {{-- SALTO LINEA****************************************** --}}
            
            <div  class="colLabel">
                <label for="fecha">Pais</label>
            </div>
            <div class="col">                  
                <input type="text" class="form-control" value=" {{ $domicilioDestino->getPais()->nombre }}" readonly>
            </div>

            <div class="colLabel"> 
                <label for="">Region</label>
            </div>

            <div class="col">
                <input type="text" class="form-control" value="{{ $domicilioDestino->getRegion()->nombre }}" readonly>
            </div>    
            <div class="colLabel"> 
                <label for="">Distrito</label>
            </div>

            <div class="col">
                <input type="text" class="form-control" value="{{ $domicilioDestino->getDistrito()->nombre }}" readonly>
            </div>    
            <div class="colLabel"> 
                <label for="">Provincia</label>
            </div>

            <div class="col">
                <input type="text" class="form-control" value="{{ $domicilioDestino->getProvincia()->nombre }}" readonly>
            </div>    
            <div class="w-100"></div> {{-- SALTO LINEA****************************************** --}}
            <div class="col"> 
                <label for="">Fecha y hora de Compra</label>
            </div>

            <div class="col">
                <input type="text" class="form-control" value="{{ $orden->fechaHoraVenta }}" readonly>
            </div>       
            <div class="col"> 
                <label for="">Estado de la orden:</label>
            </div>

            <div class="col">
                <input type="text" class="form-control" value="{{ $orden->getNombreEstado() }}" readonly>
            </div>       
            
            @if($orden->razonCancelacion!='')
                
            
            <div class="w-100"></div> {{-- SALTO LINEA****************************************** --}}
            <div class="col"> 
                <label for="">Estado de la orden:</label>
            </div>

            <div class="col">
                <input type="text" class="form-control" value="{{ $orden->razonCancelacion}}" readonly>
            </div>    


            @endif

        </div>        
           
    </div>   



  <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
            <th scope="col">Item</th>
            <th scope="col">Nombre Producto</th>
            <th scope="col"  style="text-align: center">Cantidad</th>
            <th scope="col">Precio</th>
            <th scope="col">SubTotal</th>
        </tr>

      </thead>
      <tbody>
          <?php $i=1; ?>
          @foreach($listaDetalles as $itemDetalle)      
              <tr>
                <td>{{$i}}</td>
                <td>{{$itemDetalle->getNombreProducto()}}</td>
                <td style="text-align: center"> {{ $itemDetalle->cantidad}}</td>
                <td style="text-align: right">
                    S/. {{ number_format($itemDetalle->precio,2) }}
                </td>
                <td style="text-align: right">
                    S/. {{ number_format($itemDetalle->precio* $itemDetalle->cantidad,2) }}
                </td>
                
              </tr>
              <?php $i++; ?>
          @endforeach
      </tbody>
  </table>


  <div class="row">                       
    <div class="col-md-8">
    </div>   
    <div class="col-md-2">                        
        <label for="">Total : </label>    
    </div>   
    <div class="col-md-2">
        <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly" value="S/. {{number_format($orden->total,2) }}">                              
    </div>   
    <div class="col">

    </div>

    <div style=" margin-top:20px;">
        <a href="{{route('orden.CDP',$orden->codOrden)}}" class="btn btn-info" target="_blank"> 
            Descargar comprobante de pago <i class="fas fa-file-download"> </i>
        </a> 

    </div>

    <div class="col">

    </div>

</div>

<div class="col-md-12 text-center">  
    <div id="guardar">
        <div class="form-group">
            <a href="{{route('orden.listar',$orden->codCliente)}}" 
                class='btn btn-primary' style="float:left;">
                <i class="fas fa-undo"></i>
                Regresar al menú
            </a>    
                       
        </div>    
    </div>
</div>


@endsection

