@extends('layouts.master')

@section('content')

<div class="container">
    <h1 class="text-center">CARRITO DE COMPRAS</h1>        
    <div class="alert  hidden" role="alert"></div>
    <form method="POST" action="">
    @csrf

    <div class="col-md-12 pt-3">     
        <div class="table-responsive">                           
            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                    <th width="10" class="text-center">OPCIONES</th> 
                    <th>ARTICULO</th>                                       
                    <th class="text-center">CANTIDAD</th>                                 
                    
                    <th  class="text-center">PRECIO UNITARIO</th>                                            
                    <th class="text-center">TOTAL</th>
                </thead>
                <tfoot>
                                                                                                      
                                                                                    
                </tfoot>
                <tbody>
                    
                </tbody>
            </table>
        </div> 
            <div class="row">                       
                <div class="col-md-8">
                </div>   
                <div class="col-md-2">                        
                    <label for="">Sub Total : </label>    
                </div>   
                <div class="col-md-2">
                    <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly">                              
                </div>   
            </div>
        
    </div> 

    <div class="col-md-12 text-center">  
        <div  id="guardar">
            <div class="form-group">
                <button class="btn btn-primary" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                    <i class='fas fa-save'></i> CAJA</button>    
        
                <a href="" class='btn btn-danger'><i class='fas fa-ban'></i> CARRO VACIO</a>              
            </div>    
        </div>
    </div>



@endsection