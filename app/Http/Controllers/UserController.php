<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Cliente;
use Illuminate\Support\Carbon;
use App\Carrito;
class UserController extends Controller
{

    const PAGINATION = 10; // PARA QUE PAGINEE DE 10 EN 10
    public function logearse(Request $request)
    {

        //tipoLogin=1 cuando es un login normal para iniciar sesión
        //tipoLogin=2 cuando es un login después de llenar mi carrito de manera anonima
        $tipoLogin = $request->tipoLogin;



        //error_log('El hash para '.$request->password.' es '.Hash::make($request->password));

        $data=$request->validate([
            'email'=>'required',
            'password'=>'required',
        ],
        [
            'email.required'=>'Ingrese E-mail', 
            'password.required'=>'Ingrese Contraseña',
        ]);
            $email=$request->get('email');
            $query=User::where('email','=',$email)->get();

            $rutaParaIr='indexGeneral';
            
            if($query->count()!=0){
               // error_log($query[0].'aaaaaaaaaaaaaaaaaaa');
                $hashp=$query[0]->password; // guardamos la contraseña cifrada de la BD en hashp
                $password=$request->get('password');    //guardamos la contraseña ingresada en password
                if(password_verify($password,$hashp))       //comparamos con el metodo password_verifi ??¡ xdd
                {

                    if($tipoLogin=='2')//Si he llenado un carrito anonimamente, debo sumar los items de este al carrito de mi cuenta logeada
                    {//Vengo del pago caja
                        Carrito::sumarCarritoAnonAlCarritoLogin($email);
                        $rutaParaIr='carrito.mostrar';
                    }


                    session(['token' => '-1']);
                    // Preguntamos si es admin o no
                    if($email=='admin')
                    {
                        if(Auth::attempt($request->only('email','password'))) //este attempt es para que el Auth se inicie
                            return redirect()->route($rutaParaIr);
                    }//si es user normal
                    else
                    {
                        if(Auth::attempt($request->only('email','password')))
                        {
                            
                            return redirect()->route($rutaParaIr);

                        }
                            
    
                    }
                
                }
                else{
                    return redirect()->route('user.verLogin')->with('datos','¡Contraseña no valida!');
                }                
            }
            else
            {
                return redirect()->route('user.verLogin')->with('datos','Usuario no valido!');
            }
        }


        public function index(Request $Request)
        {
            $buscarpor = $Request->buscarpor;
            $usuarios = User::where('name','like','%'.$buscarpor.'%')
                ->where('estadoAct','=','1')
                ->paginate($this::PAGINATION);
    
            //cuando vaya al index me retorne a la vista
            return view    ('tablas.usuarios.index',compact('usuarios','buscarpor')); 
            //el compact es para pasar los datos , para meter mas variables meterle mas comas dentro del compact
    
    
            // otra forma sería hacer ['categoria'] => $categoria
        }


    public function create()
    {
        
    }
    public function verLogin(){
        return view('login');
        
    }

    public function cerrarSesion(){
        Auth::logout();
        session(['token' => '-2']);
        return redirect()->route('user.verLogin');  
    }



    public function verRegistrar($tipoReg){


        return view('registrar',compact('tipoReg'));
    }


    public function store(Request $request){ //REGISTRAR NUEVO USUARIO Y CLIENTE    
        $tipoReg = $request->tipoReg;

        try {
            //code...
        
            //PRIMERO INSERTAMOS EL CLIENTE
            $cliente = new Cliente();
            $cliente->nombres = $request->nombres;
            $cliente->apellidos = $request->apellidos;
            $cliente->nroTelefonoMovil = $request->telefono;
            $cliente->save();

            //insertamos el usuaro
            $usuario = new Usuario();
            $usuario->codCliente = (Cliente::latest('codCliente')->first())->codCliente;
            $usuario-> email = $request->email;
            $usuario->password = Hash::make( $request->password); //
            $usuario->fechaActualizacion = Carbon::now()->subHours(5);
            $usuario->isAdmin = '0';

            $usuario->save();

            if($tipoReg=='1')//Caso normal
                return redirect()->route('user.verLogin')->with('datos','¡Cuenta Creada Exitosamente!');
            else //Si viene de hacer un carrito de compras y registrarse pa pagarlo, lo logeamos defrente
                {
                    //Como es nuevo usuario, debemos meter en el todos los items de su carrito anon
                    Carrito::sumarCarritoAnonAlCarritoLogin($usuario->email);

                    if(Auth::attempt($request->only('email','password')) ) //este attempt es para que el Auth se inicie
                        {
                            session(['token' => '-1']); //ya usamos el token para meter los carritos tons lo reinicio
                            return redirect()->route('carrito.mostrar');   
                        }
            
                }

        } catch (\Throwable $th) {
            error_log('
            
                ERROR EN USERCONTROLLER STORE: 

                '.$th.'
            
            
            ');
        }

    }
    public function verificarLogin(){
        $valor=0;
        if(!is_null(Auth::user())){
            $valor=1;
        }
        return $valor;
    }


}
