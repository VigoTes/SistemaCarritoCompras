@extends('layouts.master')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript"> 
    $(document).ready(function(){
        $('#codSubCategoria').change(function(){
            mostrar();
        });
        $('#codMarca').change(function(){
            mostrar();
        });
    });

    function mostrar(){
        var codigo=$('#codSubCategoria').val();
        var codigo2=$('#codMarca').val();
        var codigo3=$('#codCategoria').val();
            //alert(codigo);
            
            //if(codigo!=0){
                //alert(codigo);
                $.ajax({
                    url: '/listarProductosSubCategoria/' + codigo + '*' + codigo2 + '*' + codigo3,
                    type: 'post',
                    data: {
                        codigo     : codigo,
                        _token	 	: "{{ csrf_token() }}"
                    },
                    dataType: 'JSON',
                    success: function(respuesta) {

                        var tableValor ='';

                                    for(var i in respuesta.productos){
                                        tableValor += '<div class="col-lg-2 col-7" style="background: rgb(255, 255, 255);">';
                                            tableValor += '<img src="../../imagenes/'+respuesta.productos[i].nombreImagen+'" style="width: 100%; height: auto;">';
                                            tableValor += '<div class="container">';
                                                tableValor += '<a href="/verProducto/'+respuesta.productos[i].codProducto+'"><span>'+respuesta.productos[i].nombre+'</span></a>';
                                                tableValor += '<p style="font-weight: bold; color: #FF0000">S/. '+respuesta.productos[i].precioActual+'</p>';
                                            tableValor += '</div>';
                                        tableValor += '</div>';
                                    }

                        $('#productos').html(tableValor);

                    }
                });
            //}else{
            //            $('#productos').html('');

            //}
    }
</script>

    <div class="row">
        <section class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <input id="codCategoria" type="hidden" name="codCategoria" value="{{ $categoria->codCategoria }}" >
                    <h5>Filtros</h5>
                    <hr>
                    <label class="">SubCategoria:</label>
                    <select class="form-control" name="codSubCategoria" id="codSubCategoria">
                        <option value="0">--Seleccionar--</option>
                        @foreach($subcategorias as $itemsubcategoria)
                        <option value="{{$itemsubcategoria->codSubCategoria}}">{{$itemsubcategoria->nombre}}</option>
                        @endforeach
                    </select>
                    <br>
                    <label class="">Marca:</label>
                    <select class="form-control" name="codMarca" id="codMarca">
                        <option value="0">--Seleccionar--</option>
                        @foreach($marcas as $itemmarca)
                        <option value="{{$itemmarca->codMarca}}">{{$itemmarca->nombre}}</option>
                        @endforeach
                    </select>
               
                </div>
            </div>
        </section>
        
        <section class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="row" id="productos">
                        @foreach($productos as $itemproducto)
                        <div class="col-lg-2 col-7" style="background: rgb(255, 255, 255);">
                            <a href="{{route('producto.ver',$itemproducto->codProducto)}}">
                                <img src="../../imagenes/{{$itemproducto->nombreImagen}}" style="width: 100%; height: auto;">
                                <div class="container">
                                    
                                        <span>{{$itemproducto->nombre}}</span>
                                    
                                    <p style="font-weight: bold; color: #EE6C4D">S/. {{$itemproducto->precioActual}}</p>
                                </div>
                            </a>
                        </div>    
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>



@endsection