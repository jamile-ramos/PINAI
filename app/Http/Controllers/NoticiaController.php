<?php

namespace App\Http\Controllers;

use App\Models\CategoriaNoticia;
use App\Models\Noticia;

class NoticiaController extends Controller
{
    public function index(){
        $categorias = CategoriaNoticia::all();
        return view('noticias.index', compact('categorias'));
    }
    
}
