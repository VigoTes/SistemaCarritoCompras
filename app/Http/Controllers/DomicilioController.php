<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domicilio;
use App\Pais;
use App\Region;
use App\Distrito;
use App\Provincia;
use App\Cliente;

class DomicilioController extends Controller
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


    public function listarDomicilios($codCliente){
        $listaDomicilios = Domicilio::where('codCliente','=',$codCliente)->paginate();
        
        return view('cliente.MantenerDomicilios.index',compact('listaDomicilios'));


    }










    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) //pasamos el id del cliente
    {
       
    }

    public function crear(){
        
        $listaPaises = Pais::All();

        return view('cliente.MantenerDomicilios.create',compact('listaPaises'));


    }

    //RUTAS SERVICIOS PARA LOS SELECTS 

    public function getRegiones($id){ //id del pais
        return Region::where('codPais','=',$id)->get();
        
    }
    public function getProvincias($id){ //id de la region
        return Provincia::where('codRegion','=',$id)->get();
        
    }
    public function getDistritos($id){ //id de la provincia
        return Distrito::where('codProvincia','=',$id)->get();
        
    }







    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    public function guardar(Request $request, $codCliente)
    {
        $cliente = Cliente::findOrFail($codCliente);
        $domicilio = new Domicilio();

        $domicilio->direccion = $request->direccion;
        $domicilio->codDistrito = $request->Distrito;
        $domicilio->codigoPostal = $request->codigoPostal;
        $domicilio->nroTelefonoFijo = $request->telefonoFijo; 
        $domicilio->codCliente = $codCliente;
        $domicilio->fax = $request->fax;

        if($request->CBPrincipal == 'on')
            $domicilio->esPrincipal = '1';
        else
            $domicilio->esPrincipal = '0';
        $domicilio->save();

        return redirect()->route('domicilio.listar',$codCliente);

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
    public function edit($id) //le pasamos una id domicilio
    {
        $domicilio = Domicilio::findOrFail($id);
        $listaPaises = Pais::All();

        return view('cliente.MantenerDomicilios.edit',compact('domicilio','listaPaises'));

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

    public function actualizar(Request $request, $id)
    {
        $domicilio = Domicilio::findOrFail($id);
        $domicilio->direccion = $request->direccion;
        $domicilio->codDistrito = $request->Distrito;
        $domicilio->codigoPostal = $request->codigoPostal;
        $domicilio->nroTelefonoFijo = $request->telefonoFijo; 
        $domicilio->fax = $request->fax;

        if($request->CBPrincipal == 'on')
            $domicilio->esPrincipal = '1';
        else
            $domicilio->esPrincipal = '0';
        $domicilio->save();

        return redirect()->route('domicilio.listar',$domicilio->codCliente);


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
}
