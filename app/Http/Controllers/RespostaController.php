<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postagem;
use App\Models\Resposta;
use Illuminate\Support\Facades\Auth;
use LaravelLang\Publisher\Console\Reset;

class RespostaController extends Controller
{
    public function create($idPostagem)
    {   $postagem = Postagem::findOrFail($idPostagem);
        return view('postagens.formResposta', compact('postagem'));
    }

    public function store(Request $request, $idPostagem){

        $request->validate([
            'conteudo' => 'required|string'
        ]);

        $resposta = new Resposta;

        $resposta->conteudo = $request->conteudo;
        $resposta->idUsuario = Auth::id();
        $resposta->idPostagem = $idPostagem;

        $resposta->save();
        $postagem = Postagem::findOrFail($idPostagem);
        return redirect()->route('postagens.show', $postagem)->with('success', 'Resposta criada com sucesso!');

    }

    public function edit(Request $request, $idResposta){
        $resposta = Resposta::findOrFail($idResposta);
        $postagem = $resposta->postagem;

        return view('postagens.formResposta', compact('resposta', 'postagem'));
    }

    public function update(Request $request, $idResposta){
        $data = $request->all();
        // Atualizando os dados da notícia
        $resposta = Resposta::findOrFail($idResposta);
        $resposta->update($data);
        $postagem = $resposta->idPostagem;
        return redirect()->route('postagens.show', $postagem)->with('success', 'Resposta atualizada com sucesso!');
    }

    public function destroy($id){
        $resposta = Resposta::findOrFail($id);
        $resposta->update(['status' => 'inativo']);

        return back()->with('success-delete', 'Resposta excluida com sucesso!');
    }
}
