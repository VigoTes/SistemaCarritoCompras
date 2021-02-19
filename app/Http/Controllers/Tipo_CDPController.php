<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Tipo_CDP;
class Tipo_CDPController extends Controller
{
    public function getParametros($id){
        return Tipo_CDP::getNumeracion($id);

    }

    

}
