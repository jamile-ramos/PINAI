<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\ComentarioMencao;
use App\Models\Postagem;
use Illuminate\Support\Facades\Auth;
use App\Models\Resposta;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        // Criação do comentário
        $comentario = new Comentario;
        $comentario->conteudo = $request->conteudo;
        $comentario->idUsuario = Auth::id();
        $comentario->idResposta = $request->idResposta;

        $comentario->save();

        // Se o campo 'usuarioMencionado' foi preenchido
        if (!empty($request->usuarioMencionado)) {
            ComentarioMencao::create([
                'idComentario' => $comentario->id,
                'idUsuarioMencionado' => $request->usuarioMencionado,
                'idUsuarioMencionou' => Auth::id(),
            ]);
        }

        return back()->with('success', 'Comentário adicionado com sucesso!');
    }

    public function usuariosDaResposta($idResposta)
    {
        $comentarios = Comentario::where('idResposta', $idResposta)->get();

        $usuarios = $comentarios->map(function ($comentario) {
            return $comentario->user;
        });

        // Obter usuários únicos
        $usuariosUnicos = $usuarios->unique('id');

        // Retorna os usuários únicos convertidos em um array para o JavaScript
        return response()->json(['usuariosUnicos' => $usuariosUnicos->toArray()]);
    }
}
