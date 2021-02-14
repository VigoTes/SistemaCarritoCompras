@extends('layouts.master')

@section('content')
<div class="container">

  <h1>Editar Domicilio</h1>
  <form method="POST" action="{{route('domicilio.actualizar',$domicilio->codDomicilio) }} ">
      @method('put')
      @csrf
      
      <div class="form-group">
        <label for="nombre">Nombre del domicilio</label>
        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
          id="nombre" name="nombre" placeholder="Ingrese nombre" value="{{$domicilio->nombre}}"  >
        @error('nombre')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="nombre">Direccion</label>
        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" 
            name="direccion" placeholder="Ingrese direccion"  value="{{$domicilio->direccion}}">
        @error('direccion')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="nombre">Pais</label>
        <select class="form-control"  id="Pais" name="Pais" onchange="mostrarRegiones()">
          <option value="0">-- Seleccionar -- </option>
          @foreach($listaPaises as $itemPais)
              <option value="{{$itemPais->codPais}}" 
                @if($itemPais->codPais == $domicilio->getPais()->codPais)
                  selected
                @endif

                >
                  {{$itemPais->nombre}}
              </option>                                 
          @endforeach 
        </select>   
      </div>
      
      <div class="form-group">
        <label for="Region">Region</label>
        <select class="form-control"  id="Region" name="Region" onchange="mostrarProvincias()" >
          <option value="0">-- Seleccionar -- </option>
          @foreach($listaRegiones as $itemRegion)
              <option value="{{$itemRegion->codRegion}}" 
                @if($itemRegion->codRegion == $domicilio->getRegion()->codRegion)
                  selected
                @endif

                >
                  {{$itemRegion->nombre}}
              </option>                                 
          @endforeach
        </select>   
      </div>

      <div class="form-group">
        <label for="Provincia">Provincia</label>
        <select class="form-control"  id="Provincia" name="Provincia" onchange="mostrarDistritos()" >
          <option value="0">-- Seleccionar -- </option>
          @foreach($listaProvincias as $itemProvincia)
              <option value="{{$itemProvincia->codProvincia}}" 
                @if($itemProvincia->codProvincia == $domicilio->getProvincia()->codProvincia)
                  selected
                @endif

                >
                  {{$itemProvincia->nombre}}
              </option>                                 
          @endforeach


        </select>   
      </div>
      <div class="form-group">
        <label for="Distrito">Distrito</label>
        <select class="form-control"  id="Distrito" name="Distrito" >
          <option value="0">-- Seleccionar -- </option>
          @foreach($listaDistritos as $itemDistrito)
          <option value="{{$itemDistrito->codDistrito}}" 
            @if($itemDistrito->codDistrito == $domicilio->codDistrito)
              selected
            @endif

            >
              {{$itemDistrito->nombre}}
          </option>                                 
          @endforeach
     
        </select>   
      </div>


      <div class="form-group">
        <label for="codigoPostal">Codigo Postal</label>
        <input type="text" class="form-control @error('codigoPostal') is-invalid @enderror" 
              id="codigoPostal" name="codigoPostal" placeholder="Ingrese codigo Postal"  value="{{$domicilio->codigoPostal}}">
        @error('codigoPostal')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="fax">FAX</label>
        <input type="text" class="form-control @error('fax') is-invalid @enderror" 
              id="fax" name="fax" placeholder="Ingrese fax"  value="{{$domicilio->fax}}"> 
        @error('fax')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>
      

      <div class="form-group">
        <label for="telefonoFijo">Telefono Fijo</label>
        <input type="text" class="form-control @error('telefonoFijo') is-invalid @enderror" 
              id="telefonoFijo" name="telefonoFijo" placeholder="Ingrese telefono fijo"  value="{{$domicilio->nroTelefonoFijo}}">
        @error('telefonoFijo')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>


      {{-- DOMICILIO PRINCIPAL --}}
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input type="checkbox" name="CBPrincipal" id="CBPrincipal" aria-label="Checkbox for following text input">
          </div>
        </div>
        <input type="text" class="form-control" aria-label="Text input with checkbox" value="Este es mi Domicilio Principal"  readonly>
      </div>

      



      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Grabar</button>
    <a href="{{route('domicilio.listar',App\Cliente::getClienteLogeado()->codCliente )}}" class="btn btn-danger"><i class="fas fa-ban"></i>Cancelar</a>
  </form>
  
</div>

<script>
    $(document).ready(function(){
            $('#ComboBoxCategoria').change(function(){

                mostrarSubCategorias();
            });


            
            
        });
    
    function limpiarRegiones(){  
      limpiarProvincias();
      var sel = document.getElementById("Region");
      for (let index = 100; index >= 0; index--) {
        sel.remove(index);
      }
      var seleccionar = '<option value="0">-- Seleccionar -- </option>';
      $('#Region').append(seleccionar); 
      
    }

    function limpiarProvincias(){  
      limpiarDistritos();
      var sel = document.getElementById("Provincia");
      for (let index = 100; index >= 0; index--) {
        sel.remove(index);
      }
      var seleccionar = '<option value="0">-- Seleccionar -- </option>';
      $('#Provincia').append(seleccionar); 
      
    }

    function limpiarDistritos(){  
      var sel = document.getElementById("Distrito");
      for (let index = 100; index >= 0; index--) {
        sel.remove(index);
      }
      var seleccionar = '<option value="0">-- Seleccionar -- </option>';
      $('#Distrito').append(seleccionar); 
      
    }

    //MODELO
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

    function mostrarRegiones(){
      limpiarRegiones();
      codigo=$("#Pais").val(); 
      $.get('/mapa/getRegiones/'+codigo, function(data){      
          listaRegiones = data;
          for (let index = 0; index < listaRegiones.length; index++) {
              
              var fila = '<option value="' + listaRegiones[index].codRegion + '">' +
                      listaRegiones[index].nombre
                          + '</option>';
             

              $('#Region').append(fila);  
          } 
                  
                });
    }
    function mostrarProvincias(){
      limpiarProvincias();
      codigo=$("#Region").val(); 
      $.get('/mapa/getProvincias/'+codigo, function(data){      
          listaProvincias = data;
          for (let index = 0; index < listaProvincias.length; index++) {
              
              var fila = '<option value="' + listaProvincias[index].codProvincia + '">' +
                listaProvincias[index].nombre
                          + '</option>';
             

              $('#Provincia').append(fila);  
          } 
                  
                });
    }
    function mostrarDistritos(){
      limpiarDistritos();
      codigo=$("#Provincia").val(); 
      $.get('/mapa/getDistritos/'+codigo, function(data){      
          listaDistritos = data;
          for (let index = 0; index < listaDistritos.length; index++) {
              
              var fila = '<option value="' + listaDistritos[index].codDistrito + '">' +
                listaDistritos[index].nombre
                          + '</option>';
             

              $('#Distrito').append(fila);  
          } 
                  
                });
    }
    


</script>

@endsection