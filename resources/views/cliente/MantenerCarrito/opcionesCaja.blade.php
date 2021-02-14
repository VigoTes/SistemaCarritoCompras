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
            //}else{
            //            $('#productos').html('');

            //}
    }
</script>
<div class="well"><H3 style="text-align: center;">NUEVA EMPRESA</H3></div>

<div class="form-group row">
    <label class="col-sm-1 col-form-label" style="margin-left:350px;">Nombre:</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre..." >
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-1 col-form-label" style="margin-left:350px;">RUC:</label>
    <div class="col-sm-4">
        <input type="number" class="form-control" id="RUC" name="RUC" placeholder="RUC...">
    </div>
</div>


@endsection