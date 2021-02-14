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
        <h3>Mis Domicilios</h3>
        <a href="{{route('domicilio.crear', App\Cliente::getClienteLogeado()->codCliente )}}" class="btn btn-primary"><i class="fas fa-plus"></i>Nuevo Registro</a>
        
        {{-- <nav style="float:right" >
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar por descripcion" aria-label="Search" name="buscarpor" id="buscarpor" value="{{$buscarpor}}">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>
        </nav> --}}
        
    </div>

    @if($msj!='')<!-- cuando se registra algo-->
    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
        {{$msj}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>    
    @endif


    @if(session('datos'))<!-- cuando se registra algo-->
    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
        {{session('datos')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>    
    @endif

  <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
            <th scope="col">Codigo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Direccion</th>
            <th scope="col">Codigo Postal</th>
            <th scope="col">Telefono Fijo</th>
            <th scope="col">Fax</th>
            <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
          @foreach($listaDomicilios as $itemDomicilio)      
              <tr>
                <td>
                    
                    {{$itemDomicilio->codDomicilio}}
                
                </td>
                <td style="text-align: center">
                    @if($itemDomicilio->esPrincipal == '1')
                    <i class="fas fa-home"></i> <br>
                    @endif
                    {{$itemDomicilio->nombre}}
                </td>
                <td>{{$itemDomicilio->getDireccionCompleta()}}</td>
                <td>{{$itemDomicilio->codigoPostal}}</td>
                <td>{{$itemDomicilio->nroTelefonoFijo}}</td>
                <td>{{$itemDomicilio->fax}}</td>
                
                <td>
                <a href="{{route('domicilio.edit',$itemDomicilio->codDomicilio)}}" class="btn btn-warning btn-sm"> 
                    <i class="fas fa-edit"></i> 
                </a>
                

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
                                    window.location.href='{{route('domicilio.eliminar',$itemDomicilio->codDomicilio)}}';
                                }
                                );">
                    <i class="entypo-cancel"></i>  
                    <i class="fas fa-trash"></i>
                    
                </a>
                

                
                </td>
              </tr>
          @endforeach
      </tbody>
  </table>
  {{$listaDomicilios->links()}}





@endsection

