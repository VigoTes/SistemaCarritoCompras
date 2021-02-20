@extends('layouts.master')

@section('content')
    <script type="text/javascript"> 
          
    function validar(){
        msj='';

        nombres=$("#nombres").val(); 
        if(nombres=='')
            msj='Debe ingresar sus nombres';

        apellidos=$("#apellidos").val(); 
        if(apellidos=='')
            msj='Debe ingresar sus apellidos';

        telefonos=$("#telefono").val(); 
        if(telefonos=='')
            msj='Debe ingresar el nro de telefono';

        email=$("#email").val(); 
        if(email=='')
            msj='Debe ingresar el E-Mail';

        
        

        contraseña1=$("#contraseña").val(); 
        contraseña2=$("#contraseña2").val(); 
        
        if(contraseña1=='')
            msj='Debe ingresar la contraseña.';


        if(contraseña1!=contraseña2){
            msj = 'Las contraseñas no coinciden.';
        }


        if(msj!=''){
            alert(msj);
            return false;
        }

        
        return true;
    }

    </script>
<style>

.col{
    margin-top: 20px;
    
}


</style>


    <div class="well"><H3 style="text-align: center;">EDITAR MIS DATOS</H3></div>
    <br>
    @if(session('datos'))<!-- cuando se registra algo-->
    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
        {{session('datos')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>    
    @endif

    <form id="frmusuario" name="frmusuario" role="form" action="{{route('user.update')}}" 
        class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data" onsubmit="return validar()" style="text-align: center">
            @csrf 
            <input id="codCliente" type="hidden" name="codCliente" value="{{ $cliente->codCliente }}" >
            <input id="ocasion" type="hidden" name="ocasion" value="{{ $ocasion }}" >

        
        <div class="container">
            <div class="row">
                <div class="col"></div>
                <div class="col">

                    <label class="">Nombres:</label>
                </div>

                <div class="col">
                    
                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres..." value="{{$cliente->nombres}}" >
                  
                </div>
                <div class="col">

                    <label class="">Apellidos:</label>
                </div>
                <div class="col">
                   
               
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos..." value="{{$cliente->apellidos}}" >
                    

                </div>
                <div class="col">


                </div>
                <div class="w-100"></div> {{-- SALTO LINEA --}}
                <div class="col"></div>
                <div class="col">
                    <label >Email:</label>
                </div>
                <div class="col">
                    
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email..." value="{{$cliente->usuario()->email}}" >
                 

                </div>

                <div class="col">
                    <label >Telefono:</label>
                </div>
                <div class="col">
                    <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Telefono..." value="{{$cliente->nroTelefonoMovil}}" >
                </div>
                <div class="col"></div>
                <div class="w-100"></div> {{-- SALTO LINEA --}}
                <div class="col"></div>
                <div class="col">
                    <label >Contraseña:</label>
                </div>
                <div class="col">
                    <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="">
                </div>
                <div class="col">
                    <label >Repetir Contraseña:</label>
                </div>
                <div class="col">
                        <input type="password" class="form-control" id="contraseña2" name="contraseña2" placeholder="">
                </div>
                <div class="col"></div>

            </div>
            <div class="row" >

                <div class="col" style="text-align: center">
                    
                    <button type="submit" class="btn btn-primary" style="font-family: 'Poppins', sans-serif;">
                        <i class="far fa-save"> Guardar</i>
                    </button>
                </div>
                 
            </div>
        </div>




            

       
    </form>
@endsection
