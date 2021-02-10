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

Route::get('/', function () {
    return view('index');
});

/*-----------------RUTAS  MANTENEDORES ----------------------*/
Route::resource('categoria', 'CategoriaController');
Route::resource('marca', 'MarcaController');
Route::resource('producto', 'ProductoController');


Route::get('/categoria/listarSubs/{id}','CategoriaController@listarSubCategorias');

/* ------------------------ RUTAS ELIMINACION PARA MSJ CONFIRMACION AJAX ------------------------ */

Route::get('/categoria/eliminarCategoria/{id}','CategoriaController@eliminarCategoria');

Route::get('/subcategoria/eliminarSubCategoria/{id}','SubCategoriaController@eliminarSubcategoria');
Route::get('/marca/eliminarMarca/{id}','MarcaController@eliminarMarca');



Route::get('cancelar', function () {
    return redirect()->route('categoria.index')->with('datos','Accion Cancelada...!');
})->name('cancelar');

Route::resource('subcategoria', 'SubCategoriaController');


/**MOSTRAR CATEGORIAS PARA LOS CLIENTES */
Route::get('/categoriaCliente','CategoriaController@mostrarCategorias');
Route::get('/productoCliente/{id}','ProductoController@mostrarProducto');
Route::get('/carrito','CarritoController@mostrarCarrito');



/*
Route::get('/categoria', function () {
    return view('Categorias.index');
});
*/



//Route::get('/listarProductos','ProductoController@listarProductos');