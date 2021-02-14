<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\SubCategoria;
use Illuminate\Http\Request;

class SubCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevaSub = new SubCategoria();
        $nuevaSub->nombre = $request->nombreSubCategoria;
        $nuevaSub->estado = '1';
        $nuevaSub->codCategoria = $request->idCategoria;


        //obtenemos la cantidad de subcategorias que tiene esta categoria
        $query = SubCategoria::where('codCategoria','=',$request->idCategoria)
                ->get();
        
        //seleccionamos el idmayor
        $mayor=0;
        foreach ($query as $valor)
            {
                if($valor->nroEnCategoria > $mayor)
                $mayor=$valor->nroEnCategoria;
            }
        $nuevaSub->nroEnCategoria = $mayor+1;       //le sumamos 1 porque tiene que ser A.I
        $nuevaSub->save();


        return redirect()->route('categoria.edit',$request->idCategoria);
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
        $subCategoria = SubCategoria::findOrFail($id);
        return view('MantenerCategorias.editSubCategoria',compact('subCategoria'));
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
        $subCategoria = SubCategoria::findOrFail($id);
        $subCategoria->nombre = $request->nombre;
        $subCategoria->save();

        return redirect()->route('categoria.edit',$subCategoria->codCategoria);

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

    public function eliminarSubcategoria($id){
        $subcategoria=SubCategoria::findOrFail($id);
        $subcategoria->estado=0;
        
        $categoria=Categoria::find($subcategoria->codCategoria);

        $subcategoria->save();

        return redirect()->route('categoria.edit',$categoria->codCategoria)->with('datos','Registro Eliminado!');
    }
}
