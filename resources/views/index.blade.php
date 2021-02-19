@extends('layouts.master')

@section('content')

  <div class="container-fluid">
    <img src="../img/post.jpeg" style="width: 100%;">
  </div>
  <br>
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <h4 style="font-weight: bold">TOP FAVORITOS</h4>
    
    <div class="row">
      @foreach($productos as $itemproducto)
        
      <div class="col-lg-2 col-7" style="background: rgb(255, 255, 255);">
        <!-- small box -->
        <a href="{{route('producto.ver',$itemproducto->codProducto)}}">
          <div style="width: 100%; height: 270px;">
            <img src="../imagenes/{{$itemproducto->nombreImagen}}" style="width: 100%; height: auto;">
          </div>
          <div class="container">
            <span>{{$itemproducto->nombre}}</span>
            <p style="font-weight: bold; color: #FF0000">S/. {{$itemproducto->precioActual}}</p>
          </div>
        </a>
      </div>

      @endforeach
      
      
    </div>
    <!-- /.row -->
    <!-- Main row -->
    
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->

@endsection