<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="/loginBonitoStyle.css" />
    <title>Login</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form method="POST" action="{{route('user.logearse')}}" onsubmit="return validar()">
            <h2 class="title">Iniciar Sesión</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" id='email' name='email' placeholder="Username" title='email' />
              <span id='valida' class='i i-warning'></span>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" id='password' name='password' title='Password' placeholder="Password" />
              <span id='valida' class='i i-close'></span>
            </div>
            <div>
                <input type="submit" id='do_login' value='Ingresar' title='Get Started' class="btn solid" />
                <input type="submit" value="Ingresar Libre" class="btn solid" />
            
            </div>
            
            
            
          </form>
          <form action="#" class="sign-up-form">
            <h2 class="title">CREAR CUENTA</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Nombres" />
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Apellidos" />
            </div>
            <div class="input-field">
              <i class="fas fa-phone"></i>
              <input type="text" placeholder="Telefono" />
            </div>
            <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Email" />
              </div>
              <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="text" placeholder="Contraseña" />
              </div>
              <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Repetir contraseña" />
              </div>
            <input type="submit" class="btn" value="Registrarme" />

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
            <button class="btn transparent" id="sign-up-btn">
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
      </div>
    </div>

    <script src="/loginBonitoScript.js"></script>
  </body>
</html>