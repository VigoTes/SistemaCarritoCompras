@extends('layouts.master')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){
        $('#codSubCategoria').change(function(){

            var codigo=$('#codSubCategoria').val();
            //alert(codigo);
            
            if(codigo!=0){
                //alert(codigo);
                $.ajax({
                    url: '/listarProductosSubCategoria/' + codigo,
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
                                            tableValor += '<img src="../img/1.jpg" style="width: 100%; height: auto;">';
                                            tableValor += '<div class="container">';
                                                tableValor += '<a href="/verProducto/'+respuesta.productos[i].codProducto+'"><span>'+respuesta.productos[i].nombre+'</span></a>';
                                                tableValor += '<p style="font-weight: bold; color: #FF0000">S/. '+respuesta.productos[i].precioActual+'</p>';
                                            tableValor += '</div>';
                                        tableValor += '</div>';
                                    }

                        $('#productos').html(tableValor);

                    }
                });
            }else{
                        $('#productos').html('');

            }

        })
    });
</script>

    <div class="row">
        <section class="col-lg-3">
            <div class="card">
                <div class="card-body">
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
                            <img src="../img/1.jpg" style="width: 100%; height: auto;">
                            <div class="container">
                                <a href="{{route('producto.ver',$itemproducto->codProducto)}}"><span>{{$itemproducto->nombre}}</span></a>
                                <p style="font-weight: bold; color: #FF0000">S/. {{$itemproducto->precioActual}}</p>
                            </div>
                        </div>    
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>



@endsection