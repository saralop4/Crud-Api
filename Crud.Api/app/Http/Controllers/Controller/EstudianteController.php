<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    //metodos que van a ser accedidos o llamados desde apis

    public function index(){

        return 'Obteniendo mensaje desde controlador';
    }

    public function Create(Request $request){

    }
}
