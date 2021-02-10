<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Marca;
use App\Categoria;
use Illuminate\Support\Carbon;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const PAGINATION='20';
    public function index(Request $request)
    {
        $buscarpor = $request->buscarPor;
        $productos = Producto::all();
        
        return view('MantenerProductos.index',compact('productos','buscarpor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listaCategorias = Categoria::All();
        $listaMarcas = Marca::All();

        return view('MantenerProductos.create',compact('listaCategorias','listaMarcas'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Falta validar

        $prod = new Producto(); 
        $prod->nombre = $request->nombre;
        $prod->descripcion = $request->descripcion;
        $prod->codSubCategoria = $request->ComboBoxSubCategoria;
        $prod->codMarca = $request->ComboBoxMarca;
        $prod->precioActual = $request->precio;
        $prod->stock = $request->stock;
        $prod->descuento = $request->descuento;
        $prod->fechaActualizacion = Carbon::now()->subHours(5);
        $prod->estado = '1';
        $prod->contadorVentas = '0';

        $prod->save();
        return redirect()->route('producto.index');

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**PARA CLIENTES */
    public function mostrarProducto($id)
    {
        return view('ProductoCliente.index');
    }
}
