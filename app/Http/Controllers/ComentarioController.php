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
        $request->validate([
            'conteudo' => 'required|string|min:10|max:500',
            'idResposta' => 'required|exists:respostas,id',
        ]);

        $limiteComentarios = 10;
        $limiteComentariosUsuario = 2;

        $totalComentarios = Comentario::where('idResposta', $request->idResposta)->count();
        $totalComentariosUsuario = Comentario::where('idResposta', $request->idResposta)
            ->where('idUsuario', Auth::id())
            ->count();

        if ($totalComentarios >= $limiteComentarios) {
            return back()->withErrors(['msg' => 'Limite de comentários atingido para esta resposta.']);
        }
        if ($totalComentariosUsuario >= $limiteComentariosUsuario) {
            return back()->withErrors(['msg' => 'Você já comentou o máximo permitido nesta resposta.']);
        }

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

    public function update(Request $request, $id){

        $data = $request->validate([
            'conteudo' => 'required|string|max:1000'
        ]);

        $comentario = Comentario::findOrFail($id);

        if ($comentario->idUsuario !== Auth::id() && Auth::user()->tipoUsuario === 'comum') {
            return back()->withErrors('Você não tem permissão para editar este comentário.');
        }

        $comentario->update($data);

        return back()->with('success', 'Comentário atualizado com sucesso!');
    }

    public function destroy($id){
        $comentario = Comentario::findOrFail($id);
        $comentario->update(['status' => 'inativo']);
        return back()->with('success-delete', 'Comentário excluído com sucesso!');
    }

    /* Usuarios das mencoes*/
    public function usuariosDaResposta($idResposta)
    {
        $comentarios = Comentario::where('idResposta', $idResposta)->get();

        $usuarios = $comentarios->map(function ($comentario) {
            return $comentario->user;
        });

        $resposta = Resposta::findOrFail($idResposta);
        $usuarios->push($resposta->user);

        // Obter usuários únicos
        $usuariosUnicos = $usuarios->unique('id');

        $userAuth = Auth::user();

        // Retorna os usuários únicos convertidos em um array para o JavaScript
        return response()->json(['usuariosUnicos' => $usuariosUnicos->toArray(), 'userAuth' => $userAuth]);
    }
    
}
