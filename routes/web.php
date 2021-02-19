<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


/* RUTAS PARA INGRESO Y REGISTRO DE USUARIO Y CLIENTE */

Route::post('/ingresar', 'UserController@logearse')->name('user.logearse');  //esta es para cuando le damos al boton Ingresar
Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login
Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');
Route::get('/registrar/{tipoReg}','UserController@verRegistrar')->name('user.verRegistrar');
Route::post('/registrar', 'UserController@store')->name('user.store');  //esta es para cuando le damos al boton Ingresar
Route::get('/cliente/editar/{id}', 'UserController@verEditar')->name('user.verEditar');  //esta es para cuando le damos al boton Ingresar
Route::post('/editar', 'UserController@update')->name('user.update');  //esta es para cuando le damos al boton Ingresar

//DESPLIEGUE DE LA PAGINA PRINCIPAL
Route::get('/', function () {
    //$productos=Producto::all()->orderBy('contadorVentas')->paginate(5);
    $productos=DB::TABLE('PRODUCTO')->where('estado','=',1)->orderBy('contadorVentas')->paginate(6);
    return view('index',compact('productos'));
}  )->name('indexGeneral');


/*-----------------RUTAS  MANTENEDORES CON RESOURCE ----------------------*/
Route::resource('categoria', 'CategoriaController');
Route::resource('marca', 'MarcaController');
Route::resource('producto', 'ProductoController');
Route::resource('cliente', 'ClienteController');
Route::resource('domicilio', 'DomicilioController');
Route::resource('subcategoria', 'SubCategoriaController');


// RUTAS SERVICIOS para obtener listas
Route::get('/mapa/getRegiones/{idPais}','DomicilioController@getRegiones')->name('domicilio.getRegiones');
Route::get('/mapa/getProvincias/{idRegion}','DomicilioController@getProvincias')->name('domicilio.getProvincias');
Route::get('/mapa/getDistritos/{idProvincia}','DomicilioController@getDistritos')->name('domicilio.getDistritos');
Route::get('/categoria/listarSubs/{id}','CategoriaController@listarSubCategorias');
Route::get('/menuCategorias','CategoriaController@menuCategorias');//lista de categorias


//                          idCliente
Route::post('/cliente/domicilio/guardar/{id}','DomicilioController@guardar')->name('domicilio.guardar');

//                              idDomici
Route::put('/cliente/domicilio/actualizar/{id}','DomicilioController@actualizar')->name('domicilio.actualizar');
Route::get('/cliente/domicilio/eliminar/{id}','DomicilioController@eliminar')->name('domicilio.eliminar');
Route::get('/cliente/domicilio/crear/{id}','DomicilioController@crear')->name('domicilio.crear');
Route::get('/cliente/{id}/misdomicilios','DomicilioController@listarDomicilios')->name('domicilio.listar');



/* ------------------------ RUTAS ELIMINACION PARA MSJ CONFIRMACION AJAX ------------------------ */

Route::get('/categoria/eliminarCategoria/{id}','CategoriaController@eliminarCategoria')->name('categoria.eliminarCategoria');
Route::get('/subcategoria/eliminarSubCategoria/{id}','SubCategoriaController@eliminarSubcategoria')->name('subcategoria.eliminar');
Route::get('/marca/eliminarMarca/{id}','MarcaController@eliminarMarca')->name('marca.eliminarMarca');
Route::get('/producto/eliminarProducto/{id}','ProductoController@destroy')->name('producto.eliminarProducto');





/**MOSTRAR CATEGORIAS PARA LOS CLIENTES */

Route::get('/categoriaCliente/{id}','CategoriaController@mostrarCategorias');
Route::post('/listarProductosSubCategoria/{id}','ProductoController@listarProductosSubCategoria');

Route::get('/verProducto/{id}','ProductoController@mostrarProducto')->name('producto.ver');
Route::get('/agregarProductoCarrito/{id}','ProductoController@agregarCarrito');

//                                     idProd   
Route::get('/carrito/eliminarProducto/{id}','CarritoController@eliminarProducto')->name('carrito.eliminarProducto');
Route::get('/carrito','CarritoController@mostrarCarrito')->name('carrito.mostrar');
Route::get('/cambiarCantidadProducto/{id}','CarritoController@cambiarCantidad');

/*DE CARRITO A PAGO */
Route::get('/verificarLogin', 'UserController@verificarLogin');
Route::get('/verificarStock/{id}', 'ProductoController@verificarStock');
Route::get('/menuOpcionesCaja','CarritoController@menuOpcionesCaja')->name('carrito.verOpcionesPagoAnonimo');
Route::get('/carrito/pagar','CarritoController@mostrarVistaPagar')->name('carrito.verPagar');
Route::get('/carrito/limpiar','CarritoController@limpiar')->name('carrito.limpiar');


Route::post('/registrarCompra','CarritoController@registrarCompra')->name('carrito.registrarCompra');


Route::get('/admin/ordenes/verTodas','OrdenController@listarParaAdmin')->name('orden.listarParaAdmin');
Route::get('/admin/ordenes/next/{id}','OrdenController@next')->name('orden.next');
Route::get('/admin/ordenes/cancelar/{id}','OrdenController@cancelar')->name('orden.cancelar');
Route::get('/admin/ordenes/revisar/{id}','OrdenController@revisarOrden')->name('orden.revisarOrden');



Route::get('/cliente/ordenes/{id}','OrdenController@listar')->name('orden.listar');
Route::get('/cliente/ordenes/detalles/{id}','OrdenController@verDetalles')->name('orden.verDetalles');
Route::get('/cliente/ordenes/CDP/{id}','OrdenController@generarCDP')->name('orden.CDP');

