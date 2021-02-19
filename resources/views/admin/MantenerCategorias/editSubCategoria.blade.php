@extends('layouts.master')
@section('content')

<script type="text/javascript"> 
          
  function validar() {
    if (document.getElementById("nombre").value == ""){
        alert("Ingrese nombre de la subcategoria");
        $("#nombre").focus();
    }
    else{
        return true; // enviamos el formulario	
    }
    return false;
  }
  
</script>


    <form method="POST" action="{{route('subcategoria.update',$subCategoria->codSubCategoria)}}"    onsubmit="return validar()">
            @method('put')
            @csrf

            <div class="form-group">
                    <label for="categoria_id">Codigo:</label>
                <input type="text" class="form-control" id="codSubCategoria" name="codSubCategoria" value='{{$subCategoria->codSubCategoria}}' disabled>
            </div>

            <div class="form-group">
              <label for="nombre">Nombre:</label>
              <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"  value='{{$subCategoria->nombre}}' name="nombre">
              @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
              @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Grabar</button>
            <a href="{{route('categoria.edit',$subCategoria->codCategoria)}}" class="btn btn-danger"><i class="fas fa-ban"></i>Cancelar</a>
          </form>


@endsection