<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Producto;
use App\SubCategoria;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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



        return view('admin.MantenerCategorias.index',compact('categorias','buscarpor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.MantenerCategorias.create');
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
        
        return view('admin.MantenerCategorias.edit',compact('categoria','listaSub'));
        
        
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


    public function listarSubCategorias($idCategorias){
        $lista = SubCategoria::where('codCategoria','=',$idCategorias)->get();
        return $lista;
    }



    /**PARA CLIENTES */
    public function menuCategorias()
    {
        $categorias=Categoria::all();
        return $categorias;
    }

    public function mostrarCategorias($id)
    {
        $categoria=Categoria::findOrFail($id);
        $subcategorias=$categoria->subcategoria;

        $temp=array();//convertir la variable $temp a tipo array para meterlo a la consulta 'not in'
        foreach($subcategorias as $a){
            $temp[]=$a->codSubCategoria;
        }

        $marcas=DB::TABLE('PRODUCTO')
        ->JOIN('MARCA', 'MARCA.codMarca', '=', 'PRODUCTO.codMarca')
        ->SELECT('MARCA.codMarca as codMarca', 'MARCA.nombre as nombre')
        ->where('MARCA.estado','!=',0)->groupBy('MARCA.codMarca', 'MARCA.nombre')->orderBy('MARCA.codMarca')->get();

        $productos=Producto::whereIn('codSubCategoria',$temp)->where('estado','!=',0)->get();

        return view('cliente.CategoriasCliente.index',compact('categoria','subcategorias','marcas','productos'));
    }

    
}
