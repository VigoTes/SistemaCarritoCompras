@extends('layouts.master')

@section('content')
<div class="container">

  <h1>CREAR PRODUCTO</h1>
  <form method="POST" action="{{route('producto.update',$producto->codProducto)}}" enctype="multipart/form-data">
    @method('put')  
    @csrf
      <div class="form-group">
        <label for="nombre">Nombre del producto</label>
        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
          id="nombre" name="nombre" placeholder="Ingrese nombre" value="{{$producto->nombre}}"  >
        @error('nombre')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label">Foto:</label>
                <div class="col-sm-4">
                    <input type="file" class="form-control" name="imagen" id="imagen" accept=".jpg">
                </div>
      </div>
      <div class="form-group">
        <label for="nombre">Descripcion</label>
        <textarea id="descripcion" name="descripcion" class="form-control" 
            aria-label="With textarea" style="resize:none; height:100px;">{{$producto->descripcion}}</textarea>
        @error('descripcion')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="nombre">Categoria</label>
        <select class="form-control"  id="ComboBoxCategoria" name="ComboBoxCategoria" >
          <option value="0">-- Seleccionar -- </option>
          @foreach($listaCategorias as $itemCategoria)
              <option value="{{$itemCategoria->codCategoria}}" 
                @if($producto->getCodCategoria() == $itemCategoria->codCategoria )
                  selected
                @endif
                >
                  {{$itemCategoria->nombre}}
              </option>                                 
          @endforeach 
        </select>   
      </div>
      
      <div class="form-group">
        <label for="nombre">SubCategoria</label>
        <select class="form-control"  id="ComboBoxSubCategoria" name="ComboBoxSubCategoria" >
          <option value="-1">-- Seleccionar -- </option>
          {{-- ESTA PARTE SE HARIA CON JS --}}
          @foreach($listaSubCategorias as $itemSubCat)
              <option value="{{$itemSubCat->codSubCategoria}}" 
                @if($producto->codSubCategoria == $itemSubCat->codSubCategoria )
                  selected
                @endif
                >
                  {{$itemSubCat->nombre}}
              </option>                                 
          @endforeach
        </select>   
      </div>

      <div class="form-group">
        <label for="ComboBoxMarca">Marca</label>
        <select class="form-control"  id="ComboBoxMarca" name="ComboBoxMarca" >
          
          @foreach($listaMarcas as $itemMarca)
              <option value="{{$itemMarca->codMarca}}"
                @if($producto->codMarca == $itemMarca->codMarca )
                  selected
                @endif
                >
                  {{$itemMarca->nombre}}
              </option>                                 
          @endforeach 
        </select>   
      </div>

      <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" class="form-control" style="width: 150px;"
         id="stock" name="stock" placeholder="Ingrese stock" value="{{$producto->stock}}">
      
      </div>
      <div class="form-group">
        <label for="precio">Precio</label>
        <input type="number" step="0.01" class="form-control" style="width: 150px;"
         id="precio" name="precio" placeholder="Ingrese Precio" value="{{$producto->precioActual}}">
      
      </div>
      <div class="form-group">
        <label for="descuento">Descuento Especial</label>
        <input type="number" step="0.01" class="form-control" style="width: 150px;"
         id="descuento" name="descuento" placeholder="Ingrese descuento" value="{{$producto->descuento}}">
      
      </div>
      



      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Actualizar</button>
    <a href="{{route('producto.index')}}" class="btn btn-danger"><i class="fas fa-ban"></i>Cancelar</a>
  </form>
  
</div>

<script>
    $(document).ready(function(){
            $('#ComboBoxCategoria').change(function(){

                mostrarSubCategorias();
            });


            
            
        });
    
    function limpiarComboBoxSub(){  
      var sel = document.getElementById("ComboBoxSubCategoria");
      for (let index = 100; index >= 0; index--) {
        
        sel.remove(index);

      }
      var seleccionar = '<option value="-1">-- Seleccionar -- </option>';
      $('#ComboBoxSubCategoria').append(seleccionar); 
      
    }

    function mostrarSubCategorias(){
      limpiarComboBoxSub();

      codigo=$("#ComboBoxCategoria").val(); 
      $.get('/categoria/listarSubs/'+codigo, function(data){      
          listaSubCategorias = data;
          for (let index = 0; index < listaSubCategorias.length; index++) {
              
              var fila = '<option value="' + listaSubCategorias[index].codSubCategoria + '">' +
                              listaSubCategorias[index].nombre
                          + '</option>';
             

              $('#ComboBoxSubCategoria').append(fila);  
          } 
                  
                });

                


    }

</script>

@endsection