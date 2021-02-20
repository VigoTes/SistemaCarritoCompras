<?php

namespace App\Http\Controllers;

use App\Carrito;
use App\CarritoAnon;
use Illuminate\Http\Request;
use App\Producto;
use App\Marca;
use App\Categoria;
use App\Detalle_Carrito;
use App\Detalle_CarritoAnon;
use App\SubCategoria;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const PAGINATION='10';
    public function index(Request $request)
    {
        if($request->categoria=='')
            $request->categoria='0';

        $buscarpor = $request->buscarpor;
        if($request->categoria == '0'){ //todos
            $productos = Producto::where('PRODUCTO.estado','=','1')
            ->where('PRODUCTO.nombre','like','%'.$buscarpor.'%')
            ->orderBy('codProducto','ASC');
        
        }else{ //escogio solo una categoria
            $productos = Producto::where('PRODUCTO.estado','=','1')
            ->join('SUBCATEGORIA','SUBCATEGORIA.codSubCategoria','=','PRODUCTO.codSubCategoria')
            ->where('PRODUCTO.nombre','like','%'.$buscarpor.'%')
            ->where('SUBCATEGORIA.codCategoria','=',$request->categoria)
            ->orderBy('codProducto','ASC');

        }

        $productos=$productos ->paginate($this::PAGINATION);

        $listaCategorias = Categoria::where('estado','=','1')->get();

        return view('admin.MantenerProductos.index',compact('productos','buscarpor','listaCategorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listaCategorias = Categoria::where('estado','=','1')->get();
        $listaMarcas = Marca::All();

        return view('admin.MantenerProductos.create',compact('listaCategorias','listaMarcas'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

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
        
        //para el registro de imagenes xd
        $prod->nombreImagen='imagen'.$prod->codProducto.'.jpg';
        //$file = $request->file('imagen')->storeAs('imagenes',$prod->nombreImagen);
        Storage::disk('local2')->put($prod->nombreImagen,\File::get($request->file('imagen')));
        error_log('
        
        
        Se está subiendo la imagen '.$prod->nombreImagen.'
        
        
        
        ');
        //$imagen =$request->file('imagen');
        //Storage::disk('imagenes')->put($prod->nombreImagen,\File::get($imagen));
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
        $producto = Producto::findOrFail($id);
        $listaCategorias = Categoria::where('estado','=','1')->get();
        $listaMarcas = Marca::All();
        //subcat de la cat que tiene actualmente
        $listaSubCategorias = SubCategoria::where('codCategoria','=',$producto->getCodCategoria())->get();


        
        return view('admin.MantenerProductos.edit',compact('producto','listaCategorias','listaMarcas','listaSubCategorias'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        
        $prod = Producto::findOrFail($id);
        
        $prod->nombre = $request->nombre;
        $prod->descripcion = $request->descripcion;
        $prod->codSubCategoria = $request->ComboBoxSubCategoria;
        $prod->codMarca = $request->ComboBoxMarca;
        $prod->precioActual = $request->precio;
        $prod->stock = $request->stock;
        $prod->descuento = $request->descuento;
        $prod->fechaActualizacion = Carbon::now()->subHours(5);
        $prod->estado = '1';
        //$prod->contadorVentas = '0';


        if(!is_null($request->imagen)){
            //Storage::disk('local')->delete($prod->nombreImagen);
            Storage::disk('local2')->delete($prod->nombreImagen);
                                        //$prod->nombreImagen='imagen'.$prod->codProducto.'.jpg';
            Storage::disk('local2')->put($prod->nombreImagen,\File::get($request->file('imagen')));
            //$file = $request->file('imagen')->storeAs('imagenes',$prod->nombreImagen);
            error_log('
        
        
            Se está subiendo la imagen '.$prod->nombreImagen.'
            
            
            
            ');

        }

        $prod->save();
        return redirect()->route('producto.index')->with('¡Se ha actualizado el producto!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = '2';
        $producto->save();
        return redirect()->route('producto.index')->with('datos','Registro Eliminado!');


    }

    /**PARA CLIENTES */
    public function listarProductosSubCategoria(Request $request,$id){

        try {
            //code...
        

                $arr = explode('*', $id);
                if($arr[0]==0 && $arr[1]==0){
                    $categoria=Categoria::find($arr[2]);
                    $subcategorias=$categoria->subcategoria;
                    $temp=array();//convertir la variable $temp a tipo array para meterlo a la consulta 'not in'
                    foreach($subcategorias as $a){
                        $temp[]=$a->codSubCategoria;
                    }
                    //$productos=Producto::where('estado','=',1)->get();
                    $productos=Producto::whereIn('codSubCategoria',$temp)->where('estado','=',1)->get();
                }
                else{
                    $productos=Producto::where('codSubCategoria','=',$arr[0])->where('codMarca','=',$arr[1])->where('estado','=',1)->get();
                    if($arr[0]==0){
                        $productos=Producto::where('codMarca','=',$arr[1])->where('estado','=',1)->get();
                    }
                    if($arr[1]==0){
                        $productos=Producto::where('codSubCategoria','=',$arr[0])->where('estado','=',1)->get();
                    }
                }
                return response()->json(['productos'=>$productos]);
            } catch (\Throwable $th) {
                error_log('
                    OCURRIO UN ERROR EN 
                    ProductoController : listarProductosSubCategoria
                
                '.$th.'
                
                ');
            }    


    }

    public function mostrarProducto($id)
    {
        $producto=Producto::findOrFail($id);
        return view('cliente.ProductoCliente.verProducto',compact('producto'));
    }

    /* AGREGA UN PRODUCTO AL CARRITO  */
    public function agregarProducto($cadena){ 

        try {
            
        

            date_default_timezone_set('America/Lima');


            $arr = explode('*', $cadena);

            $producto=Producto::findOrFail($arr[0]);
            //Preguntamos si hay un usuario logeado
            if(is_null(Auth::user())){ //CARRITO ANON 
                $token = session('token');

                error_log('AGREGARCARRITO--------
                
                ------------ TOKEN OBTENIDO:'.$token.' 
                
                
                ');


                
                if($token>0){ //Si el token existe, es porque este usuario ya creó un carrito
                    $ListacarritoNON=CarritoAnon::where('codCarrito','=', $token)->get();
                    $carritoNON = $ListacarritoNON[0]; //obtenemos el carrito ya creado
                    $token = session('token'); //obtenemos el token  ya creado
                }
                else //usuario que recien va a crear su carrito (primer producto añadido)
                {
                    $numero_aleatorio = rand(1,1000);
                    $token = $numero_aleatorio;
                    $carritoNON=new CarritoAnon();
                    $carritoNON->codCarrito=$token;
                    $carritoNON->save();

                    //NUEVO TOKEN 
                    session(['token' => $token]); //GUARDAMOS ESE TOKEN EN LA SESION DEL USUARIO CONECTADO para que luego lo pueda obtener  
                }
                
                $temp=0;
                $verificacionDetalles=Detalle_CarritoAnon::where('codCarrito','=',$token)->get();
                foreach ($verificacionDetalles as $itemdetalle) {
                    if($itemdetalle->codProducto==$producto->codProducto) {$temp=$itemdetalle->codDetCarrito;}
                }
          
                if($temp!=0){
                
                    $detalle=Detalle_CarritoAnon::find($temp);
                    $detalle->cantidad+=$arr[1];
                    $detalle->save();
                }
                else{
                    //Creamos un nuevo detalle y lo añadimos al carrrito
                    $detalle=new Detalle_CarritoAnon();
                    $detalle->codProducto=$producto->codProducto;
                    $detalle->cantidad=$arr[1];
                    $detalle->codCarrito=$token;
                    $detalle->save();
                }
                
            }
            else{           // CARRITO CON CLIENTE LOGEADO 

                
                //lee los carritos del cliente
                $carritos=Carrito::where('codCliente','=',  Auth::user()->codCliente )->get();
                
                
                
                if(count($carritos) == 0 ){
                    $carrito=new Carrito();
                    $carrito->codCliente=Auth::user()->codCliente;
                    $carrito->fechaHora=new DateTime();
                    $carrito->save();
                }
                else{
                    $carrito=$carritos[0];
                }

                $temp=0;
                $verificacionDetalles=Detalle_Carrito::where('codCarrito','=',$carrito->codCarrito)->get();
                foreach ($verificacionDetalles as $itemdetalle) {
                    if($itemdetalle->codProducto==$producto->codProducto) {$temp=$itemdetalle->codDetCarrito;}
                }
                error_log('AGREGARCARRITO--------
                    
                ------------ TEMP:'.$temp.' 
                
                
                ');
                if($temp!=0){
                    $detalle=Detalle_Carrito::find($temp);
                    $detalle->cantidad+=$arr[1];
                    $detalle->save();
                }
                else{
                    //Creamos un nuevo detalle y lo añadimos al carrrito
                    $detalle=new Detalle_Carrito();
                    $detalle->codProducto=$producto->codProducto;
                    $detalle->cantidad=$arr[1];
                    $detalle->codCarrito=$carrito->codCarrito;
                    $detalle->save();
                }

                
            }

            return redirect()->route('producto.ver',$producto->codProducto)->with('datos','¡Producto añadido al carrito!');
            /* return redirect('/verProducto/'.$producto->codProducto); */
            
        } catch (\Throwable $th) {
            error_log('HA OCURRIDO UN ERROR EN PRODUCTO CONTROLLER AGREGAR CARRITO 
            
            '.$th.'
            
            

        ');
        }


    }

    public function verificarStock($id)
    {
        $producto=Producto::findOrFail($id);
        return $producto->stock;
    }


    function indexListarTop () {
        //$productos=Producto::all()->orderBy('contadorVentas')->paginate(5);
        $productos=DB::TABLE('PRODUCTO')->where('estado','=',1)->orderBy('contadorVentas')->paginate(6);
        return view('index',compact('productos'));
    }

    function indexFiltro (Request $request) {
        //$productos=Producto::all()->orderBy('contadorVentas')->paginate(5);
        $filtro = strtolower($request->filtro);
    
        $productosQuery = DB::select(            
            '
            SELECT * from public."PRODUCTO" where lower("nombre") like \'%'.$filtro.'%\' and "estado"=1'

        );
        //tenemos los datos pero no como modelos

        /* los pasamos a modelos */
        $productos=[];
        for ($i=0; $i < count($productosQuery); $i++) { 
            $item = Producto::findOrFail($productosQuery[$i]->codProducto);
            array_push( $productos,$item);
        }

        
        return view('index',compact('productos'));
    }


    /* -- reporte de las categorias mas vendidas
select P."nombre",P."contadorVentas", SC."nombre", C."nombre" from public."PRODUCTO" P
	inner join public."SUBCATEGORIA" SC on P."codSubCategoria" = SC."codSubCategoria"
	inner join public."CATEGORIA" C on C."codCategoria" = SC."codCategoria"
 */


    public function reporteProductos(){

        $categoriasMasVendidas = DB::select('
      
        select sum(P."contadorVentas") as cant, C."nombre" as name from public."PRODUCTO" P
            inner join public."SUBCATEGORIA" SC on P."codSubCategoria" = SC."codSubCategoria"
            inner join public."CATEGORIA" C on C."codCategoria" = SC."codCategoria"
            group by C."nombre"
        ');
        $fechaI='';
        $fechaF='';

        $subCategoriasMasVendidas = DB::select('
        select sum(P."contadorVentas") as cant, SC."nombre" as name from public."PRODUCTO" P 
        inner join public."SUBCATEGORIA" SC on P."codSubCategoria" = SC."codSubCategoria"
            group by SC."nombre"
        ');

        return view('admin.Reportes.reporte',compact('categoriasMasVendidas','fechaI','fechaF','subCategoriasMasVendidas'));

    }
}
