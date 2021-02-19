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
        <h3>Clientes</h3>
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
            <th scope="col">Codigo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Telefono</th>
            <th scope="col">Direccion</th>
            <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
          @foreach($listaClientes as $itemCliente)      
              <tr>
                <td>{{$itemCliente->codCliente}}</td>
                <td>{{$itemCliente->nombres.' '.$itemCliente->apellidos}}</td>
                <td>{{$itemCliente->nroTelefonoMovil}}</td>
                <td>{{$itemCliente->getDireccionCompleta()}}</td>
                
                <td>
                <a href="{{route('user.verEditar',$itemCliente->codCliente.'*1')}}" class="btn btn-warning btn-sm"> 
                    <i class="fas fa-edit"></i> 
                </a>
                
                
                </td>
              </tr>
          @endforeach
      </tbody>
  </table>
  {{$listaClientes->links()}}





@endsection

