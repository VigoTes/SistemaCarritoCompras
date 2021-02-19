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

<div class="container">

  <h1>CREAR REGISTRO</h1>
  <form method="POST" action="{{route('categoria.store')}}" onsubmit="return validar()">
      @csrf
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" placeholder="Ingrese nombre">
        @error('nombre')
          <span class="invalid-feedback" role="alert">
              <strong>{{$message}}</strong>
          </span>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Grabar</button>
    <a href="{{route('categoria.index')}}" class="btn btn-danger"><i class="fas fa-ban"></i>Cancelar</a>
  </form>
  
</div>

@endsection