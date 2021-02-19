@extends('layouts.master')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



<div class="well"><H3 style="text-align: center;">CONFIRMAR LA ENTRADA</H3></div>
<div class="form-group row">
    <p class="col-sm-6" style="margin-left:350px;">
        Seleccione uno de las opciones.
    </p>
</div>

<div class="form-group" style="margin-left:350px;">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="radio1" id="val1" value="1" checked="">
      <label class="">Ya estoy registrado</label>
    </div>
    <p>Si usted se ha registrado antes, ingrese su email y su contraseña para confirmar la entrada.</p>

    <form method="POST" action="{{route('user.logearse')}}" id="frmRegistrado" name="frmRegistrado"  onsubmit="return validar()">
        @csrf
        {{-- PARA SABER EN EL CONTROLLER DE DONDE VIENE (si de aqui o del login principal)  --}}
        <input type="hidden" name="tipoLogin" id="tipoLogin" value="2">

        <div class="form-group row" style="margin-left:100px;">
            <label class="col-sm-1 col-form-label">Email:</label>
            <div class="col-sm-4" style="margin-left:40px;">
                <input type="text" class="form-control" id="email" name="email" placeholder="Email..." >
            </div>
        </div>
        <div class="form-group row" style="margin-left:100px;">
            <label class="col-sm-1 col-form-label">Contraseña:</label>
            <div class="col-sm-4" style="margin-left:40px;">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña..." >
            </div>
        </div>
        <input class="btn btn-primary" type='submit' id='do_login' value='Ingresar' title='Get Started' />
        
        
    </form>

    <br>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="radio1" id="val2" value="2">
      <label class="">Soy un nuevo usuario</label>
    </div>
    <p>Si usted no se ha registrado antes, pulse aqui</p>
    {{--                                2 porque viene del pagar --}}
    <a href="{{route('user.verRegistrar','2')}}" class="btn btn-primary">Registrarme</a>

</div>

<script>
$(document).ready(function(){
        $("#val1").click(function () {
            espacio = '';
                espacio += '<div class="form-group row" style="margin-left:100px;" id="espacio1">';
                    espacio += '<label class="col-sm-1 col-form-label">Email:</label>';
                    espacio += '<div class="col-sm-4" style="margin-left:15px;">';
                        espacio += '<input type="text" class="form-control" id="email" name="email" placeholder="Email..." >';
                    espacio += '</div>';
                espacio += '</div>';
                espacio += '<div class="form-group row" style="margin-left:100px;" id="espacio2">';
                    espacio += '<label class="col-sm-1 col-form-label">Contraseña:</label>';
                    espacio += '<div class="col-sm-4" style="margin-left:15px;">';
                        espacio += '<input type="text" class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña..." >';
                    espacio += '</div>';
                espacio += '</div>';
            $('#frmRegistrado').html(espacio);
        });
        $("#val2").click(function () {
            $('#frmRegistrado').html('');
        });

		$("#boton").click(function () { 
			valor=$('input:radio[name=radio1]:checked').val();
            if(valor==1){
                document.frmRegistrado.submit();
            }else{
                window.location.href='/registrar';
            }
		});
});
</script>

<script type="text/javascript"> 
          
    function validar() {
      if (document.getElementById("email").value == ""){
          alert("Ingrese email de la categoria");
      }
      else if (document.getElementById("password").value == ""){
          alert("Ingrese password de la categoria");
      }
      else{
          return true; // enviamos el formulario	
      }
      return false;
    }
    
  </script>

@endsection