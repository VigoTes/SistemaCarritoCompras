@extends('layouts.master')

@section('content')
    <div class="row">
        <section class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5>Filtros</h5>
                    <hr>
                    <label class="">SubCategoria:</label>
                    <select class="form-control" name="codArea" id="codArea">
                        <option value="0">--Seleccionar--</option>
                    </select>
                    <br>
                    <label class="">Marca:</label>
                    <select class="form-control" name="codArea" id="codArea">
                        <option value="0">--Seleccionar--</option>
                    </select>
               
                </div>
            </div>
        </section>
        <section class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-2 col-7" style="background: rgb(255, 255, 255);">
                          <!-- small box -->
                            <img src="../img/1.jpg" style="width: 100%; height: auto;">
                            <div class="container">
                                <a href="/productoCliente/1"><span>Polo Deportivo Silo - S</span></a>
                                <p style="font-weight: bold; color: #FF0000">S/. 50.00</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </section>
    </div>



@endsection