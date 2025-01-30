<?php

namespace App\Http\Controllers;

use App\Models\CategoriaNoticia;
use App\Models\Noticia;
use Illuminate\Support\Facades\Auth;


class NoticiaController extends Controller
{
    public function index(){
        $categorias = CategoriaNoticia::all();
        $minhasNoticias = $this->myNoticias(); 
        return view('noticias.index', compact('categorias', 'minhasNoticias'));
    }

    public function myNoticias(){
        $idUsuario = Auth::user()->id;
        $minhasNoticias = Noticia::where('idUsuario', $idUsuario)->get();
        return $minhasNoticias;
    }
    
}
