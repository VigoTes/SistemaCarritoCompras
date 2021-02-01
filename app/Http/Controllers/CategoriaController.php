<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\SubCategoria;

use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const PAGINATION='20';
    public function index(Request $request)
    {
        $buscarpor=$request->buscarpor;
        $categorias=Categoria::where('estado','=',1)
        ->where('nombre','like','%'.$buscarpor.'%')
        ->orderBy('codCategoria','ASC')
                ->paginate($this::PAGINATION);



        return view('MantenerCategorias.index',compact('categorias','buscarpor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('MantenerCategorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=request()->validate([
            'nombre'=>'required|max:100',
        ],[
            'nombre.required'=>'Ingrese nombre de categoria',
            'nombre.max'=>'Maximo de 100 caracteres para nombre',
        ]);

        $categoria= new Categoria();
        $categoria->nombre=$request->nombre;
        $categoria->estado=1;
        $categoria->save();

        return redirect()->route('categoria.index')->with('datos','Registro Nuevo Guardado!!');
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
        
        $categoria=Categoria::find($id);
        $listaSub=SubCategoria::where('codCategoria','=',$id)
        ->where('estado','=','1')
        ->orderBy('nroEnCategoria','ASC')
        ->get();
        //return $listaSub;
        //return "hola";
        
        return view('MantenerCategorias.edit',compact('categoria','listaSub'));
        
        
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
        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $request->nombrecategoria;
        $categoria->save();
        

        return redirect()->route('categoria.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //return "hola".$id;
        $categoria=Categoria::findOrFail($id);
        $categoria->estado=0;
        $categoria->save();


        
        return redirect()->route('categoria.index')->with('datos','Registro Eliminado!');


    }

    public function eliminarCategoria($id){
        $categoria=Categoria::findOrFail($id);
        $categoria->estado=0;
        $categoria->save();


        
        return redirect()->route('categoria.index')->with('datos','Registro Eliminado!');
    }
}
