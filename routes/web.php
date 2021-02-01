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

/* MANTENER CATEGORIAS */
Route::resource('categoria', 'CategoriaController');
Route::get('/categoria/eliminarCategoria/{id}','CategoriaController@eliminarCategoria');
Route::get('cancelar', function () {
    return redirect()->route('categoria.index')->with('datos','Accion Cancelada...!');
})->name('cancelar');

Route::resource('subcategoria', 'SubCategoriaController');
Route::get('/subcategoria/eliminarSubCategoria/{id}','SubCategoriaController@eliminarSubcategoria');



/*
Route::get('/categoria', function () {
    return view('Categorias.index');
});
*/



//Route::get('/listarProductos','ProductoController@listarProductos');