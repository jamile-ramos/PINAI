<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaTopico;

class TopicoController extends Controller
{
    public function index(){
        return view('topicos.index');
    }

    public function create(){
        return view('topicos.form');
    }
}
