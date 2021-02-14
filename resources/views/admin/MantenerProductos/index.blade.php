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
        <h3>LISTADO DE PRODUCTOS</h3>
        <a href="{{route('producto.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>Nuevo Registro</a>
        
        <nav style="float:right" >
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar por descripcion" aria-label="Search" name="buscarpor" id="buscarpor" value="{{$buscarpor}}">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>
        </nav>
        
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
            <th scope="col">Categoria</th>
            <th scope="col">Subcategoria</th>
            <th scope="col">Marca</th>
            <th scope="col">Stock</th>
            <th scope="col">Precio</th>
            <th scope="col">Descuento</th>
            <th scope="col"> <i class="fas fa-calendar-day"></i> Actualizacion</th>
            <th scope="col">#Ventas</th>
                

            <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
          @foreach($productos as $itemProducto)      
              <tr>
                <td>{{$itemProducto->codProducto}}</td>
                <td>{{$itemProducto->nombre}}</td>
                <td>{{$itemProducto->getNombreCategoria()}}</td>
                <td>{{$itemProducto->getNombreSubcategoria()}}</td>
                <td>{{$itemProducto->getNombreMarca()}}</td>
                <td>{{$itemProducto->stock}}</td>
                <td>{{$itemProducto->precioActual}}</td>
                <td>{{$itemProducto->descuento}}</td>
                <td>    {{$itemProducto->fechaActualizacion}}</td>
                <td>{{$itemProducto->contadorVentas}}</td>
                


                  <td>
                    <a href="{{route('producto.edit',$itemProducto->codProducto)}}" class="btn btn-warning btn-sm"> 
                        <i class="fas fa-edit"></i> 
                        
                    </a>
                    <!--
                    <a href="/producto/eliminarproducto/{{$itemProducto->codProducto}}" class="btn btn-danger btn-sm"> <i class="fas fa-edit"></i> Eliminar</a>
                    -->
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
                                        window.location.href='{{route('producto.eliminarProducto',$itemProducto->codProducto)}}';
                                    

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
{{--   {{$productos->links()}} --}}





@endsection

