<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/adminlte/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/adminlte/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/adminlte/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


  <!-- PARA SOLUCIONAR EL PROBLEMA DE 'funcion(){' EN js--->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

  <!-- LIBRERIAS PARA NOTIFICACION DE ELIMINACION--->
  <script src="/adminlte/dist/js/sweetalert.min.js"></script>
  <link rel="stylesheet" href="/adminlte/dist/css/sweetalert.css">


</head>

<script type="text/javascript">
  $.get('/menuCategorias', function(data){      
    categorias = data;

    var menuCategoria='';
    for(var i in categorias){
      menuCategoria += '<li class="nav-item">';
        menuCategoria += '<a href="/cliente/categoria/'+categorias[i].codCategoria+'" class="nav-link">';
          menuCategoria += '<i class="far fa-circle nav-icon"></i>';
          menuCategoria += '<p>'+categorias[i].nombre+'</p>';
        menuCategoria += '</a>';
      menuCategoria += '</li>';
    }
    $('#menuCategorias').append(menuCategoria);

  });
</script>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    {{-- Left navbar links  --}}
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        
      </li>
      
      
    </ul>
    <!-- SEARCH FORM  PARA BUSCAR PRODUCTOS -->
    <form class="form-inline ml-3" action="{{route('indexFiltro')}}" onsubmit="">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" name="filtro" id="filtro" type="search" placeholder="Buscar por nombre" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    
    
    <div style="float: left; color:rgb(255, 248, 248)">
      @if( session('token')!='' )
        <label for="">Token: {{session('token')}}</label>
      @endif

    </div> 
    
    
    
    
    
    
    
    
    
  




    <!-- SEARCH FORM -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu --> {{-- VER CARRITO RAPIDAMENTE --}}
      
      
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-shopping-cart"></i>
          <span class="badge badge-danger navbar-badge">
            {{App\Usuario::getNroDetallesCarrito()}}
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          
          
          @foreach(App\Usuario::getdetallesCarrito() as $detalleCarrito)
          <div class="dropdown-divider"></div>
          <a href="{{route('producto.ver',$detalleCarrito->codProducto)}}" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../imagenes/{{$detalleCarrito->getProducto()->nombreImagen}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  {{$detalleCarrito->getProducto()->getNombreSubCategoria()}}
                  <span class="float-right text-sm text-warning">{{-- <i class="fas fa-star"></i> --}}</span>
                </h3>
                <p class="text-sm">{{$detalleCarrito->getNombreProducto()}}</p>
                <p class="text-sm text-muted">
                
                   S/. {{$detalleCarrito->cantidad*$detalleCarrito->getProducto()->precioActual}}
                </p>
              </div>
            </div>


            <a href="{{route('carrito.mostrar')}}" class="dropdown-item dropdown-footer">Ver mi Carrito</a>
            <!-- Message End -->
          </a>

          @endforeach
          
        
        </div>


      </li>  
      {{-- finnnnnnnnnnnnnnnnnn  --}}

     <div>
        @if(  Auth::id() =='' )
        {{-- <label for=""> No logeado </label> --}}
        <a href="{{route('user.verLogin')}}" class="btn btn-warning btn-sm"> 
          <i class="far fa-user fa-x2"></i>
          Iniciar Sesión
         </a>
        @else
          <label for=""> {{ App\Usuario::getEmailPorCodUsuario(Auth::id())  }} </label>
          {{-- sesion={{session('sesionX')}} --}}
          <a href="{{route('user.verEditar',Auth::user()->usuario->codCliente.'*2')}}" class="btn btn-warning btn-sm"> 
            <i class="fas fa-user-cog"></i>
           </a>
        @endif  

        
     </div>
        
        
      
      <!-- Notifications Dropdown Menu -->
      

    </ul>

   

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('indexGeneral')}}" class="brand-link">
      <img src="/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">ISO Carrito</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            @if(  Auth::id() !='' )
              <label for=""> {{ App\Usuario::getEmailPorCodUsuario(Auth::id())  }} </label>
            @else
            <label for="">Anonimo</label>
            @endif
          </a>
        </div>
      </div>


      {{-- SIDE BAR MIO --}}
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
          <li class="nav-item menu-close">
            <a href="" class="nav-link">
              <i class="fas fa-list-alt"></i>
              <p>
                Categorías
                <i class="right fas fa-angle-left"></i>
              </p>
            </a> 
            <ul class="nav nav-treeview" id="menuCategorias">
           
              {{-- aqui va el contenido que se agrega mediante JS DE LAS CATEGORIAS --}}
   
            </ul>
          </li>

          <li class="nav-item">
            <a href="/carrito" class="nav-link">
              <i class="fas fa-users"></i>
              <p>
                Carrito
              </p>
            </a>
          </li>
        @if(  Auth::id()!='' ){{-- SI ESTÁ LOGEADO --}}
          <li class="nav-item">
            <a href="{{route('domicilio.listar', (App\Usuario::getClientePorCodUsuario(Auth::id()) )->codCliente  )}}" class="nav-link">
              <i class="fas fa-users"></i>
              <p>
                Mis Domicilios
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('orden.listar', (App\Usuario::getClientePorCodUsuario(Auth::id()) )->codCliente  )}}" class="nav-link">
              <i class="fas fa-users"></i>
              <p>
                Mis Ordenes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('user.verEditar',Auth::user()->usuario->codCliente.'*2')}}" class="nav-link">
              <i class="fas fa-users"></i>
              <p>
                Mis Datos
              </p>
            </a>
          </li>
        @endif
        @if(Auth::id()=='1')
          <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-list-alt"></i>
                <p>
                  MANTENEDORES
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{route('categoria.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Categorías</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="{{route('marca.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Marcas</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('producto.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Productos</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('cliente.index')}}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Clientes</p>
                      </a>
                    </li>
                      
              </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('orden.listarParaAdmin')}}" class="nav-link">
              <i class="fas fa-users"></i>
              <p>
                Ordenes todas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="fas fa-list-alt"></i>
              <p>
                Reportes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Productos</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Clientes</p>
                    </a>
                  </li>

                  

            </ul>
          </li>
        @endif


          <li class="nav-item">
            <a href="{{route('user.cerrarSesion')}}" class="nav-link">
              <i class="fas fa-sign-out-alt"></i>
              <p>
                Cerrar Sesión
              </p>
            </a>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->



    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">





      {{-- ESTO PARA BORRARLO  --}}    
    <!-- Content Header (Page header) -->


    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!--
            <h1 class="m-0 text-dark">Dashboard</h1>
            -->
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            {{-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol> --}}
          </div><!-- /.col -->


        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>



    <!-- /.content-header -->






    <!-- Main content -->
    <section class="content">

        @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  {{-- <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div>
  </footer> --}}

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/adminlte/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/adminlte/plugins/moment/moment.min.js"></script>
<script src="/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) 
<script src="/adminlte/dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="/adminlte/dist/js/demo.js"></script>



</body>
</html>
