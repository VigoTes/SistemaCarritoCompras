@extends('layouts.master')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<section class="content">
  
  
  
  @if(session('datos'))<!-- cuando se registra algo-->
  <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
      {{session('datos')}}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
  </div>    
  @endif


    <!-- Default box -->
    <div class="card card-solid">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <h3 class="d-inline-block d-sm-none">{{$producto->nombre}}</h3>
            <div class="col-12">
              {{-- 8000/clientejasdjj/ --}}
              {{-- 8000/cliente/categoria --}}
              {{-- LO QUE TENGO /cliente/imagenes/imagen19 --}}
              {{--              /imagenes/imagen19 --}}
              
              <img src="/imagenes/{{$producto->nombreImagen}}" class="product-image" alt="Product Image">

            </div>
            <!--
            <div class="col-12 product-image-thumbs">
              <div class="product-image-thumb"><img src="../../dist/img/prod-1.jpg" alt="Product Image"></div>
              <div class="product-image-thumb"><img src="../../dist/img/prod-2.jpg" alt="Product Image"></div>
              <div class="product-image-thumb"><img src="../../dist/img/prod-3.jpg" alt="Product Image"></div>
              <div class="product-image-thumb"><img src="../../dist/img/prod-4.jpg" alt="Product Image"></div>
              <div class="product-image-thumb active"><img src="../../dist/img/prod-5.jpg" alt="Product Image"></div>
            </div>
            -->
          </div>
          <div class="col-12 col-sm-6">
            <h3 class="my-3">{{$producto->nombre}}</h3>
            <p>{{$producto->descripcion}}</p>
            <hr>
            <div class="bg-gray py-2 px-3 mt-4">
              <h2 class="mb-0">
                S/. {{$producto->precioActual}}
              </h2>
              <!--class="mb-0" -->
            </div>

            <div class="row mt-2">
              <div class="col-md-2">
                <input type="number" min="1" class="form-control" id="cantidad" name="cantidad" value="1" onchange="validar()">
              </div>
              <!--
              <a href="" class="btn btn-primary btn-lg btn-flat">
                <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                Add to Cart
              </a>
            --> 
              <a href="#" class="btn btn-primary" onclick="swal({//sweetalert
                    title:'<h3>¿Seguro de agregar el producto al carrito?',
                    text: '{{$producto->nombre}}',     //mas texto
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

                  $.get('/verificarStock/{{$producto->codProducto}}', function(data){
                    cantidadProducto=parseInt(data);
                    cantidadMarcada= parseInt($('#cantidad').val() );

                    if(cantidadProducto < cantidadMarcada){
                      alert('Stock insuficiente, solo se dispone de '+cantidadProducto+' unidades');
                    }else{
                      window.location.href='/agregarProductoCarrito/'+{{$producto->codProducto}}+'*'+cantidadMarcada;
                    }
                  });

                  //var cantidad=$('#cantidad').val();
                  //window.location.href='/agregarProductoCarrito/'+{{$producto->codProducto}}+'*'+cantidad;

                });"><i class="fas fa-cart-plus fa-lg mr-2"></i>Añadir al Carrito</a>
              
            </div>

          </div>
        </div>
        
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>


<script>
   function validar(){
    cantidadActual=$('#cantidad').val();
        if(cantidadActual<1){
          $('#cantidad').val(1);
        }
    }
</script>
@endsection