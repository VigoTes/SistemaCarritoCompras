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


<div >
  <h3>LISTADO DE MARCAS</h3>
  <a href="{{route('marca.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>Nuevo Registro</a>
  
  <nav class="navbar float-right">
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
  
  <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Codigo</th>
          <th scope="col">Nombre</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
          @foreach($marcas as $itemMarca)      
              <tr>
                  <td>{{$itemMarca->codMarca}}</td>
                  <td>{{$itemMarca->nombre}}</td>
                  <td>
                    <a href="{{route('marca.edit',$itemMarca->codMarca)}}" class="btn btn-warning btn-sm"> 
                        <i class="fas fa-edit"></i> 
                        Editar
                    </a>
                    <!--
                    <a href="/marca/eliminarmarca/{{$itemMarca->codMarca}}" class="btn btn-danger btn-sm"> <i class="fas fa-edit"></i> Eliminar</a>
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
                                        $.ajax(
                                            {
                                            url : '/marca/eliminarMarca/{{$itemMarca->codMarca}}',
                                            data: { },
                                            type:'get',
                                            success:  function (response) 
                                                {
                                                    //console.log(response);
                                                    //$('#CargarContenido').empty().append($(response));
                                                    //window.location.reload();
                                                    //alert('Mensaje');
                                                    window.location.href='{{route('marca.index')}}';
                                                },
                                                statusCode: {// es como un catch
                                                },
                                                error:function(x,xs,xt){//error por defecto no definido en el statusCode
                                                    //window.open(JSON.stringify(x));
                                                    console.log('error: ' + JSON.stringify(x) +'\n error string: '+ xs + '\n error throwed: ' + xt);
                                                }
                                            });

                                    }
                                    );">
                        <i class="entypo-cancel"></i>  
                        <i class="fas fa-trash"></i>
                        Eliminar
                    </a>
                    


                  </td>
              </tr>
          @endforeach
      </tbody>
  </table>
  {{$marcas->links()}}





@endsection

