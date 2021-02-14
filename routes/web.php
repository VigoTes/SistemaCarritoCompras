<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/ingresar', 'UserController@logearse')->name('user.logearse');  //esta es para cuando le damos al boton Ingresar
Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login
Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');

/* Route::get('/login', function () {
    return redirect()->route('user.verLogin');
}); */


Route::get('/', function () {
    return view('index');
})->name('indexGeneral');

/*-----------------RUTAS  MANTENEDORES ----------------------*/
Route::resource('categoria', 'CategoriaController');
Route::resource('marca', 'MarcaController');
Route::resource('producto', 'ProductoController');
Route::resource('cliente', 'ClienteController');
Route::resource('domicilio', 'DomicilioController');


// RUTAS SERVICIOS para obtener listas de paises, regiones, distritos
Route::get('/mapa/getRegiones/{idPais}','DomicilioController@getRegiones')->name('domicilio.getRegiones');
Route::get('/mapa/getProvincias/{idRegion}','DomicilioController@getProvincias')->name('domicilio.getProvincias');
Route::get('/mapa/getDistritos/{idProvincia}','DomicilioController@getDistritos')->name('domicilio.getDistritos');

//                          idCliente
Route::post('/domicilio/guardar/{id}','DomicilioController@guardar')->name('domicilio.guardar');

//                              idDomici
Route::put('/domicilio/actualizar/{id}','DomicilioController@actualizar')->name('domicilio.actualizar');
Route::get('/domicilio/eliminar/{id}','DomicilioController@eliminar')->name('domicilio.eliminar');


Route::get('/domicilio/crear/{id}','DomicilioController@crear')->name('domicilio.crear');

Route::get('/cliente/{id}/domicilios','DomicilioController@listarDomicilios')->name('domicilio.listar');


Route::get('/categoria/listarSubs/{id}','CategoriaController@listarSubCategorias');

/* ------------------------ RUTAS ELIMINACION PARA MSJ CONFIRMACION AJAX ------------------------ */

Route::get('/categoria/eliminarCategoria/{id}','CategoriaController@eliminarCategoria')->name('categoria.eliminarCategoria');

Route::get('/subcategoria/eliminarSubCategoria/{id}','SubCategoriaController@eliminarSubcategoria')->name('subcategoria.eliminar');
Route::get('/marca/eliminarMarca/{id}','MarcaController@eliminarMarca')->name('marca.eliminarMarca');

Route::get('/producto/eliminarProducto/{id}','ProductoController@destroy')->name('producto.eliminarProducto');


Route::get('cancelar', function () {
    return redirect()->route('categoria.index')->with('datos','Accion Cancelada...!');
})->name('cancelar');

Route::resource('subcategoria', 'SubCategoriaController');


/**MOSTRAR CATEGORIAS PARA LOS CLIENTES */
Route::get('/menuCategorias','CategoriaController@menuCategorias');

Route::get('/categoriaCliente/{id}','CategoriaController@mostrarCategorias');
Route::post('/listarProductosSubCategoria/{id}','ProductoController@listarProductosSubCategoria');

Route::get('/verProducto/{id}','ProductoController@mostrarProducto')->name('producto.ver');
Route::get('/agregarProductoCarrito/{id}','ProductoController@agregarCarrito');

Route::get('/carrito','CarritoController@mostrarCarrito')->name('carrito.mostrar');

//                                     idProd   
Route::get('/carrito/eliminarProducto/{id}','CarritoController@eliminarProducto')->name('carrito.eliminarProducto');


/*
Route::get('/categoria', function () {
    return view('Categorias.index');
});
*/



//Route::get('/listarProductos','ProductoController@listarProductos');