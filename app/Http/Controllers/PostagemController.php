<?php

namespace App\Http\Controllers;

use App\Models\Postagem;
use Illuminate\Http\Request;
use App\Models\Topico;

class PostagemController extends Controller
{
    public function index($id){
        $topico = Topico::findOrFail($id);

        $postagens = $topico->postagens()->withCount('respostas')->get();

        return view('postagens.index', compact('postagens'));
    }

    public function create(){
        return view('postagens.create');
    }
}
