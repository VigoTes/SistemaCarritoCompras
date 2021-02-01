@extends('layouts.master')
@section('content')


<form method = "POST" action = "{{route('categoria.update',$categoria->codCategoria)}}"  >
    @method('put')
    @csrf   

  <div class="form-group">

   <div class="container">  {{-- Container  --}}
        <div class="row">
            <div class="col">
                {{-- CONTENIDO DE LA COLUMNA --}}
                <label for="nombrecategoria">Nombre de la Categoria</label>
                <input type="text" class="form-control @error('nombrecategoria') is-invalid @enderror"
                         value='{{$categoria->nombre}}' 
                    id="nombrecategoria" name="nombrecategoria" placeHolder="Ingrese el nombre de la categoria">

                        @error('nombrecategoria')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  


                {{-- FIN CONTENIDO COLUMNA --}}
            </div>
            <div class="col">
                {{-- CONTENIDO COLUMNA --}}
                
                    
                {{-- FIN CONTENIDO COLUMNA --}}
            </div>
            <div class="w-100"></div>
            <div class="col"> 
                 {{-- CONTENIDO COLUMNA --}}
                
                <div style=         "float: right;">    

                <br>
                 <button type="submit" class="btn btn-primary">   <i class="fas fa-save"> </i> Grabar </button>
                    <a href = "{{route('categoria.index')}}" class = "btn btn-danger">
                        <i class="fas fa-ban"> </i> Cancelar </a>   {{-- BOTON CANCELARRRRRRRRRRRRRRRRR --}}
                </div>

                 {{-- FIN CONTENIDO COLUMNA--}}
            </div>



        </div>
    </div>
   </div>

</form> {{-- FORM GRUP --}}











{{-- SEGUNDA SEPARACION AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA --}}






















<form method = "POST" action = "{{route('subcategoria.store')}}"  >
    @csrf   

  <div class="form-group">

   <div class="container">  {{-- Container  --}}
        <div class="row">
        
            <div class="col"> 
                 {{-- CONTENIDO COLUMNA --}}
                <br>
                
                <label for="descripcion">SubCategorias</label>
                <br>
                    <div class="container">
                        <div class="row">
                            
                             {{-- INPUT INVISIBLE PARA GUARDAR EL VALOR DE LA ID categoria --}}   
                            <input type="hidden" class="form-control" 
                                        id="idCategoria" name="idCategoria" value = {{$categoria->codCategoria}}>
                            
                            <div class="col">
                            {{-- ESTE ES EL INPUTO DEL QUE QUIERO AGARRAR SU VALOR --}}
                                <input type="text" class="form-control @error('nombreSubCategoria') is-invalid @enderror" 
                                        id="nombreSubCategoria" name="nombreSubCategoria" >
                                    @error('nombreSubCategoria')
                                        <span class = "invalid-feedback" role ="alert">
                                            <strong>{{ $message }} </strong>
                                        </span>
                                    @enderror  


                            </div>

                            <div class="col">
                                <button type="submit" class="btn btn-primary">  
                                           <i class="fas fa-plus"> </i>  Nueva SubCategoria 
                                    </button>
                                
                            </div>
                            
                        </div>
                    </div>

                <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>

                            <th scope="col" style = "width: 5%">#</th>
                            <th scope="col" style = "width: 60%">Nombre</th>
                     
                            <th scope="col" style = "width: 20%">Opciones</th>
                            
                            </tr>
                        </thead>
                        <tbody>

                        {{-- LISTADO DE LOS OBJETIVOS DE LA categoria --}}
                        @foreach($listaSub as $itemSub)
                        
                            <tr>
                                <td>{{$itemSub->nroEnCategoria}}</td>
                                
                                <td>{{$itemSub->nombre}}</td>
                                

                                <td> <a href="" class = "btn btn-warning">  
                                        <i class="fas fa-edit"> </i> 
                                        Editar
                                    </a>
                                    <!--
                                    <a href="" class = "btn btn-danger"> 
                                        <i class="fas fa-trash-alt"> </i> 
                                        Eliminar
                                    </a>   
                                    -->
                                    <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Eliminar registro" onclick="swal({//sweetalert
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
                                    function(){//se ejecuta cuando damos a aceptar
                                        $.ajax({
                                            url : '/subcategoria/eliminarSubCategoria/{{$itemSub->nroEnCategoria}}',
                                            data: { },
                                            type:'get',
                                            success:  function (response) {
                                                //console.log(response);
                                                //$('#CargarContenido').empty().append($(response));
                                                //window.location.reload();
                                                //alert('Mensaje');
                                                window.location.href='{{route('categoria.edit',$categoria->codCategoria)}}';
                                            },
                                            statusCode: {// es como un catch
                
                                            },
                                            error:function(x,xs,xt){//error por defecto no definido en el statusCode
                                                //window.open(JSON.stringify(x));
                                                console.log('error: ' + JSON.stringify(x) +'\n error string: '+ xs + '\n error throwed: ' + xt);
                                            }
                                        });
                
                                    });"><i class="entypo-cancel"></i>Eliminar</a>
                                </td>
                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                

                 {{-- FIN CONTENIDO COLUMNA--}}
            </div>
        </div>
    </div>
   </div>

</form> {{-- FORM GRUP --}}



@endsection