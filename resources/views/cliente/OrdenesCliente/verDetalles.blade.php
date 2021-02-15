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


    <div style="margin-bottom:25px;">
        <h3>Detalles de la orden</h3>
        {{-- <a href="" class="btn btn-primary"><i class="fas fa-plus"></i>Nuevo Registro</a>
         --}}
        {{-- <nav style="float:right" >
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar por descripcion" aria-label="Search" name="buscarpor" id="buscarpor" value="{{$buscarpor}}">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>
        </nav> --}}
        
        @if(session('datos'))<!-- cuando se registra algo-->
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                {{session('datos')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>    
        @endif
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

