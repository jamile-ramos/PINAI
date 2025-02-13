<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Postagem;
use Illuminate\Support\Facades\Auth;
use App\Models\Resposta;

class ComentarioController extends Controller
{
    public function store(Request $request){
        $comentario = new Comentario;

        $comentario->conteudo = $request->conteudo;
        $comentario->idUsuario = Auth::id();
        $comentario->idResposta = $request->idResposta;
    
        $comentario->save();

        return back()->with('success', 'Comentário adicionado com sucesso!');
    }
    
    
}
