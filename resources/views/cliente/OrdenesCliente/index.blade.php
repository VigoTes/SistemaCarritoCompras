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
        <h3>Órdenes</h3>
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
            <th width="5%" scope="col">Código</th>
            <th  width="7%" scope="col">Fecha</th>
            <th  width="7%" scope="col">Hora</th>
            
            <th width="40%"  scope="col">Resumen</th>
            <th  width="7%" scope="col">Domicilio</th>
            <th  width="10%" scope="col">Total</th>
            <th width="5%"  scope="col">Cbte</th>
            <th width="20%"  scope="col">Estado</th>
            <th  width="8%" scope="col">Revisar</th>
            
        </tr>
      </thead>
      <tbody>
          @foreach($listaOrdenes as $itemOrden)      
              <tr>
                <td>{{$itemOrden->codOrden}}</td>
                <td>{{$itemOrden->getFecha()}}</td>
                <td>{{$itemOrden->getHora()}}</td>
                
                <td>{{$itemOrden->getResumen()}}</td>
                <td>{{$itemOrden->getDomicilio()->nombre}}</td>
                <td>S/. {{number_format( $itemOrden->total,2)}}</td>
                <td>{{$itemOrden->getTipoCDP()}}</td>
                <td style="text-align: center;" style="color: ">
                    <input type="text" value="{{$itemOrden->getEstado()}}" class="form-control" readonly 
                    style="background-color: {{$itemOrden->getColorEstado()}};
                            width:95%;
                            text-align:center;
                            color : {{$itemOrden->getColorLetrasEstado()}} ;
                    ">
                   
                
                </td>
                
                <td style="text-align: center;">
                    <a href="{{route('orden.verDetalles',$itemOrden->codOrden)}}" class="btn btn-warning btn-sm"> 
                    <i class="fas fa-eye"></i> 
                    </a> 
                    <a href="{{route('orden.CDP',$itemOrden->codOrden)}}" class="btn btn-info btn-sm" target="_blank"> 
                        <i class="fas fa-file-download"></i>
                    </a> 
                
                </td>
              </tr>
          @endforeach
      </tbody>
  </table>
  {{$listaOrdenes->links()}}





@endsection

