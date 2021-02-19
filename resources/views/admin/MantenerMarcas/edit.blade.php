@extends('layouts.master')
@section('content')

<script type="text/javascript"> 
          
    function validar() {
      if (document.getElementById("nombre").value == ""){
          alert("Ingrese nombre de la categoria");
          $("#nombre").focus();
      }
      else{
          return true; // enviamos el formulario	
      }
      return false;
    }
    
  </script>

<form method = "POST" action = "{{route('marca.update',$marca->codMarca)}}"   onsubmit="return validar()">
    @method('put')
    @csrf   

  <div class="form-group">

   <div class="container">  {{-- Container  --}}
        <div class="row">
            <div class="col">
                {{-- CONTENIDO DE LA COLUMNA --}}
                <label for="nombre">Nombre de la marca</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                         value='{{$marca->nombre}}' 
                    id="nombre" name="nombre" placeHolder="Ingrese el nombre de la marca">

                        @error('nombre')
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
                    <a href = "{{route('marca.index')}}" class = "btn btn-danger">
                        <i class="fas fa-ban"> </i> Cancelar </a>   {{-- BOTON CANCELARRRRRRRRRRRRRRRRR --}}
                </div>

                 {{-- FIN CONTENIDO COLUMNA--}}
            </div>



        </div>
    </div>
   </div>

</form> {{-- FORM GRUP --}}










@endsection