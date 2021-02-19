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
        <h3>Ordenes de los clientes</h3>
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
  
  <table class="table table-striped" style="font-size: 11pt;">
      <thead class="thead-dark">
        <tr>
            <th  width="3%">Código</th>
            <th  width="7%">Fecha</th>
            <th  width="7%">Hora</th>
            <th width="50%">Resumen</th>
        
            <th  width="7%">Total</th>
         
            <th width="12%" >Estado</th>
            
            <th width="7%">Revisar</th>
            
        </tr>
      </thead>
      <tbody>
          @foreach($listaOrdenes as $itemOrden)      
              <tr>
                <td style="text-align: center">{{$itemOrden->codOrden}}</td>
                <td>{{$itemOrden->getFecha()}}</td>
                <td>{{$itemOrden->getHora()}}</td>
                <td>{{$itemOrden->getResumen()}}</td>
        
                <td>S/.{{number_format( $itemOrden->total,2)}}</td>
               
                <td style="text-align: center;" style="color: ">
                    <input type="text" value="{{$itemOrden->getEstado()}}" class="form-control" readonly 
                    style="background-color: {{$itemOrden->getColorEstado()}};
                            width:95%;
                            text-align:center;
                            color : {{$itemOrden->getColorLetrasEstado()}} ;
                    ">
                   
                
                </td>
                
                <td style="text-align: center">
                    <a href="{{route('orden.revisarOrden',$itemOrden->codOrden)}}" class="btn btn-warning btn-sm"> 
                        <i class="fas fa-eye"></i> 
                    </a> 
                </td>
              </tr>
          @endforeach
      </tbody>
  </table>
  {{$listaOrdenes->links()}}





@endsection

