<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postagem;    
use App\Models\Resposta;
use Illuminate\Support\Facades\Auth;

class RespostaController extends Controller
{
    public function create($id)
    {   $postagem = Postagem::findOrFail($id);
        return view('postagens.formResposta', compact('postagem'));
    }

    public function store(Request $request, $id){
        $resposta = new Resposta;

        $resposta->conteudo = $request->conteudo;
        $resposta->idUsuario = Auth::id();
        $resposta->idPostagem = $id;

        $resposta->save();
        $postagem = Postagem::findOrFail($id);
        return redirect()->route('postagens.show', $postagem)->with('success', 'Resposta criada com sucesso!');

    }
}
