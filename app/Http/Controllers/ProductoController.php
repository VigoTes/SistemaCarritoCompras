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
        $productos = Producto::where('estado','=','1') ->orderBy('codProducto','ASC')->get();
        
        return view('admin.MantenerProductos.index',compact('productos','buscarpor'));
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
    public function update(Request $request, $id)
    {
        
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
        $prod->contadorVentas = '0';

        $prod->save();
        return redirect()->route('producto.index');

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

    public function agregarCarrito($cadena){ 

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

            return redirect()->route('producto.ver',$producto->codProducto);
            /* return redirect('/verProducto/'.$producto->codProducto); */

        } catch (\Throwable $th) {
            error_log('HA OCURRIDO UN ERROR EN PRODUCTO CONTROLLER AGREGAR CARRITO 
            
            '.$th.'
            
            

        ');
        }


    }
}
