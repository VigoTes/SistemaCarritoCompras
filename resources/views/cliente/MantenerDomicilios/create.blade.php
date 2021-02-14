@extends('layouts.master')

@section('content')
<div class="container">

  <h1>Registrar Nuevo Domicilio</h1>
  <form method="POST" action="{{route('domicilio.guardar',App\Cliente::getClienteLogeado()->codCliente)}}">

      @csrf
      <div class="form-group">
        <label for="nombre">Nombre del domicilio</label>
        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" placeholder="Ingrese nombre">
        @error('nombre')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="nombre">Direccion</label>
        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" placeholder="Ingrese direccion">
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
              <option value="{{$itemPais->codPais}}" >
                  {{$itemPais->nombre}}
              </option>                                 
          @endforeach 
        </select>   
      </div>
      
      <div class="form-group">
        <label for="Region">Region</label>
        <select class="form-control"  id="Region" name="Region" onchange="mostrarProvincias()" >
          <option value="0">-- Seleccionar -- </option>
          {{-- ESTA PARTE SE HARIA CON JS --}}
          
        </select>   
      </div>

      <div class="form-group">
        <label for="Provincia">Provincia</label>
        <select class="form-control"  id="Provincia" name="Provincia" onchange="mostrarDistritos()" >
          <option value="0">-- Seleccionar -- </option>
        
        </select>   
      </div>
      <div class="form-group">
        <label for="Distrito">Distrito</label>
        <select class="form-control"  id="Distrito" name="Distrito" >
          <option value="0">-- Seleccionar -- </option>
         
        </select>   
      </div>


      <div class="form-group">
        <label for="codigoPostal">Codigo Postal</label>
        <input type="text" class="form-control @error('codigoPostal') is-invalid @enderror" 
              id="codigoPostal" name="codigoPostal" placeholder="Ingrese codigo Postal">
        @error('codigoPostal')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="fax">FAX</label>
        <input type="text" class="form-control @error('fax') is-invalid @enderror" 
              id="fax" name="fax" placeholder="Ingrese fax">
        @error('fax')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>
      

      <div class="form-group">
        <label for="telefonoFijo">Telefono Fijo</label>
        <input type="text" class="form-control @error('telefonoFijo') is-invalid @enderror" 
              id="telefonoFijo" name="telefonoFijo" placeholder="Ingrese telefono fijo">
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
  /*   $(document).ready(function(){
           

      sleep(200);
          alert('a');
          mostrarRegiones();
          sleep(200);
          mostrarProvincias()
          sleep(200);
          mostrarDistritos();

        }); 
    } */
        function sleep(milliseconds) {
          var start = new Date().getTime();
          for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - start) > milliseconds){
              break;
            }
          }
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
    
    /* ---------------------------------- LIMPIAR --------------------------------- */
    
    function limpiarRegiones(){  
      var sel = document.getElementById("Region");
      for (let index = 100; index >= 0; index--) {
        sel.remove(index);
      }
      var seleccionar = '<option value="0">-- Seleccionar -- </option>';
      $('#Region').append(seleccionar); 
      
    }

    function limpiarProvincias(){  
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

</script>

@endsection