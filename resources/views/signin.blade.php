<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/img/carro-de-la-compra (2).svg" />

    
    <link rel="stylesheet" href="/loginBonitoStyle.css" />

   
      <!-- LIBRERIAS PARA NOTIFICACION DE ELIMINACION--->
  
      <link rel="stylesheet" href="/adminlte/dist/css/sweetalert.css">
    
{{-- 
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">

 --}}
    <title>Login</title>
  </head>

  <body>
   

    <div class="container">
      <div class="forms-container"  >
        <div class="signin-signup">
            <form method="POST" action="{{route('user.logearse')}}" onsubmit="return validar()" class="sign-in-form">
                @csrf
                {{-- 
                  
                  @if(session('datos'))<!-- cuando se registra algo-->
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                    {{session('datos')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>    
                @endif
                 --}}
                {{-- HIDDEN PARA ALMACENAR EL TIPO REG, POR DEFECTO ES 1 (LOGIN) Y 2(DEL PAGO) --}}
                <input type="hidden" id="tipoReg" name="tipoReg" value="1">
                <h2 class="title">Ingresar</h2>

                <h3 >
                  <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                    {{session('datos')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>  
                </h3>    

                <div class="input-field">
                      <i class="fas fa-user"></i>
                      <input type="text" id='email' name='email'  placeholder="Correo" />
                </div>
                <div class="input-field">
                      <i class="fas fa-lock"></i>
                      <input type="password" placeholder="Contraseña" />
                </div>
                <div>
                    <input type="submit" value="Ingresar" class="btn solid" style="text-align: center;"  />
                    <input type="button" onclick="irAlIndex()" value="Ingreso libre" class="btn solid" style="text-align: center;" />    
                </div>
              </form>
              


          {{-- FORM PARA AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA --}}
          <form action="#" class="sign-up-form">
            {{-- HIDDEN PARA ALMACENAR EL TIPO REG, POR DEFECTO ES 1 (LOGIN) Y 2(DEL PAGO) --}}
            <input type="hidden" id="tipoReg" name="tipoReg" value="{{$tipoReg}}">

            <h2 class="title">CREAR CUENTA</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Nombres" id='nombres' name='nombres' title='nombres' />
              <span id='valida' class='i i-warning'></span>
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Apellidos" id='apellidos' name='apellidos' title='apellidos'/>
              <span id='valida' class='i i-warning'></span>
            </div>
            <div class="input-field">
              <i class="fas fa-phone"></i>
              <input type="text" placeholder="Telefono" id='telefono' name='telefono' title='telefono' />
              <span id='valida' class='i i-close'></span>
            </div>
            <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Email" id='email' name='email' title='email' />
                <span id='valida' class='i i-close'></span>
            </div>
              <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="text" placeholder="Contraseña" id='password' name='password' title='Password' />
                    <span id='valida' class='i i-close'></span>
              </div>
              <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Repetir contraseña" id='password2' name='password2' title='Password2' />
                    <span id='valida' class='i i-close'></span>
              </div>
              <input type="submit" id='do_login' class="btn" value="Registrarme" title='Get Started'/>

          </form>
        </div>
      </div>

      <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>¿AÚN NO TIENES UNA CUENTA?</h3>
                    <p>
                        Crea tu cuenta y recibe 20% extra en tu primera compra.
                    </p>
                    <button href="{{route('user.verRegistrar','1')}}" class="btn transparent" id="sign-up-btn">
                    REGISTRARSE
                    </button>
                </div>
                <img src="/img/e-commerce.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>¡Hola! Inicia sesión,</h3>
                    <p>
                        para ofrecerte una mejor experiencia web.
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                    INICIAR SESIÓN
                    </button>
                </div>
                <img src="/img/e-commerce.svg" class="image" alt="" />
            </div>
      </div>{{-- FORMS CONTAINERS --}}
    </div>{{-- CONTAINER --}}

    <script src="/loginBonitoScript.js"></script>
    <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

    <script src="/adminlte/dist/js/sweetalert.min.js"></script>


<script>
    function irAlIndex(){

        location.href="{{route('indexGeneral')}}";
    }
    
        
    function validar(){
      
      msj='';

      email=$("#email").val(); 
      if(email=='')
        msj='Debe ingresar el E-Mail';

      contraseña=$("#password").val(); 
    
      if(contraseña=='')
        msj='Debe ingresar la contraseña.';


      if(msj!=''){
        alert(msj);
        return false;
      }

      
      return true;
    }


  </script>
  
    </body>

  
<!-- Summernote -->
<script src="/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.js"></script>




<script src="/adminlte/dist/js/demo.js"></script>
<script src="/adminlte/dist/js/sweetalert.min.js"></script>

<link rel="stylesheet" href="/adminlte/dist/css/sweetalert.css">

<script src="/adminlte/dist/js/sweetalert.min.js"></script>
<script src="/adminlte/plugins/moment/moment.min.js"></script>
<script src="/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>



</html>