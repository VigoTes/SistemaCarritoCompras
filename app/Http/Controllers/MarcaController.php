<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marca;
class MarcaController extends Controller
{
    const PAGINATION='20';
    public function index(Request $request)
    {
        $buscarpor=$request->buscarpor;
        $marcas=Marca::where('estado','=',1)
        ->where('nombre','like','%'.$buscarpor.'%')
        ->orderBy('codMarca','ASC')
                ->paginate($this::PAGINATION);



        return view('MantenerMarcas.index',compact('marcas','buscarpor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('MantenerMarcas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevaMarca = new Marca();
        $nuevaMarca->nombre = $request->nombre;
        $nuevaMarca->estado = '1';
        $nuevaMarca->save();

        return redirect()->route('marca.index');

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
        $marca=Marca::findOrFail($id);
    
        
        return view('MantenerMarcas.edit',compact('marca'));
        
    
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
        $marca = Marca::findOrFail($id);
        $marca->nombre = $request->nombre;
        $marca->save();
        

        return redirect()->route('marca.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        



    }


    public function eliminarMarca($id){
        $marca=Marca::findOrFail($id);
        $marca->estado=0;
        $marca->save();


        
        return redirect()->route('marca.index')->with('datos','Registro Eliminado!');
    }
}
