@extends('layouts.master')

@section('content')
<div class="container">

  <h1>CREAR PRODUCTO</h1>
  <form method="POST" action="{{route('producto.store')}}" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="nombre">Nombre del producto</label>
        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" placeholder="Ingrese nombre">
        @error('nombre')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>



      <div class="form-group row">
        <label class="col-sm-1 col-form-label">Foto:</label>
                <div class="col-sm-9">
                  {{--   <input type="file" class="btn btn-primary" name="imagen" id="imagen" accept=".jpg"> --}}
                   
                      <input type="file" class="input" name="imagen" id="imagen" accept=".jpg" style="visibility: hidden">
                      <label class="label" for="imagen">
                        <div id="divFile">
                          Escoger archivo 
                        </div>
                        <i class="fas fa-upload"></i> 
                      </label>
                      
                </div>
      </div>


      <div class="form-group">
        <label for="nombre">Descripcion</label>
        <textarea id="descripcion" name="descripcion" class="form-control" aria-label="With textarea" style="resize:none; height:100px;"></textarea>
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
              <option value="{{$itemCategoria->codCategoria}}" >
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
          
        </select>   
      </div>

      <div class="form-group">
        <label for="ComboBoxMarca">Marca</label>
        <select class="form-control"  id="ComboBoxMarca" name="ComboBoxMarca" >
          <option value="-1">-- Seleccionar -- </option>
          @foreach($listaMarcas as $itemMarca)
              <option value="{{$itemMarca->codMarca}}" >
                  {{$itemMarca->nombre}}
              </option>                                 
          @endforeach 
        </select>   
      </div>
      
      <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" class="form-control" style="width: 150px;"
         id="stock" name="stock" placeholder="Ingrese stock">
      
      </div>
      <div class="form-group">
        <label for="precio">Precio</label>
        <input type="number" step="0.01" class="form-control" style="width: 150px;"
         id="precio" name="precio" placeholder="Ingrese Precio">
      
      </div>
      <div class="form-group">
        <label for="descuento">Descuento Especial</label>
        <input type="number" step="0.01" class="form-control" style="width: 150px;"
         id="descuento" name="descuento" placeholder="Ingrese descuento" value="0">
      
      </div>
      



      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Grabar</button>
    <a href="{{route('producto.index')}}" class="btn btn-danger"><i class="fas fa-ban"></i>Cancelar</a>
  </form>
  
</div>


<style>

    input[type=”file”]#imagen {
      width: 0.1px;
      height: 0.1px;
      opacity: 0;
      overflow: hidden;
      position: absolute;
      z-index: -1;
      visibility: hidden;
    }

    label[for="imagen"] {
      font-size: 14px;
      font-weight: 600;
      color: #fff;
      background-color: #106BA0;
      display: inline-block;
      transition: all .5s;
      cursor: pointer;
      padding: 15px 40px !important;
      text-transform: uppercase;
      width: fit-content;
      text-align: center;
    }



</style>


{{-- PARA EL FILE BONITO --}}
<script type="application/javascript">
      jQuery('input[type=file]').change(function(){
        var filename = jQuery(this).val().split('\\').pop();
        var idname = jQuery(this).attr('id');
        console.log(jQuery(this));
        console.log(filename);
        console.log(idname);
        jQuery('span.'+idname).next().find('span').html(filename);
        document.getElementById("divFile").innerHTML= filename;
      });
</script>

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