<?php

namespace App\Http\Controllers;

use App\Events\UsuarioMencionado;
use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\ComentarioMencao;
use App\Models\Postagem;
use Illuminate\Support\Facades\Auth;
use App\Models\Resposta;
use App\Models\User;
use App\Notifications\UsuarioAtivoNotification;
use App\Notifications\UsuarioMencionadoNotification;
use Illuminate\Support\Facades\Notification;

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

        $totalComentarios = Comentario::where('idResposta', $request->idResposta)->where('status', 'ativo')->count();
        $totalComentariosUsuario = Comentario::where('idResposta', $request->idResposta)
            ->where('status', 'ativo')
            ->where('idUsuario', Auth::id())
            ->count();

        if ($totalComentarios >= $limiteComentarios) {
            return back()->withErrors(['msg' => 'Limite de comentários atingido para esta resposta.']);
        }
        if ($totalComentariosUsuario >= $limiteComentariosUsuario) {
            return back()->withErrors(['msg' => 'Você já comentou o máximo permitido nesta resposta.']);
        }

        $comentario = Comentario::create([
            'conteudo'   => $request->conteudo,
            'idUsuario'  => Auth::id(),
            'idResposta' => $request->idResposta,
        ]);

        // Processa menções se existirem
        if (!empty($request->mencoes)) {
            $mencoes = json_decode($request->mencoes, true);

            if (is_array($mencoes)) {
                foreach ($mencoes as $mencao) {
                    ComentarioMencao::create([
                        'idComentario'       => $comentario->id,
                        'idUsuarioMencionado' => $mencao['id'],
                        'idUsuarioMencionou' => Auth::id(),
                    ]);
                    // dispara email para o usuário mencionado
                    event(new UsuarioMencionado($comentario));

                    // Notificação do site para usuario mencionado
                    $usuarioMencionado = User::find($mencao['id']);

                    if ($usuarioMencionado) {
                        $usuarioMencionado->notify(new UsuarioMencionadoNotification($comentario));
                    }
                }
            }
        }

        return back()->with('success', 'Comentário adicionado com sucesso!');
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'conteudo' => 'required|string|max:1000',
        ]);

        $comentario = Comentario::findOrFail($id);

        if ($comentario->idUsuario !== Auth::id() && Auth::user()->tipoUsuario === 'comum') {
            return back()->withErrors('Você não tem permissão para editar este comentário.');
        }

        $comentario->update([
            'conteudo' => $data['conteudo'],
        ]);

        // Atualiza menções (se veio no request)
        if ($request->has('mencoes')) {
            $raw = $request->input('mencoes');

            if (is_string($raw)) {
                $parsed = json_decode($raw, true) ?: [];
            } else {
                $parsed = is_array($raw) ? $raw : [];
            }

            $ids = collect($parsed)
                ->map(function ($item) {
                    if (is_array($item)) {
                        return $item['id'] ?? $item['idUsuarioMencionado'] ?? null;
                    }
                    return is_numeric($item) ? (int) $item : null;
                })
                ->filter()
                ->unique()
                ->values()
                ->all();

            // Limpa e recria menções
            $comentario->mencoes()->detach();
            foreach ($ids as $idUsuarioMencionado) {
                $comentario->mencoes()->attach($idUsuarioMencionado, [
                    'idUsuarioMencionou' => Auth::id(),
                ]);
            }
        }

        return back()->with('success', 'Comentário atualizado com sucesso!');
    }


    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->update(['status' => 'inativo']);
        return back()->with('success-delete', 'Comentário excluído com sucesso!');
    }

    public function buscarUsuarios(Request $request, $respostaId)
    {
        $termo = $request->query('q');

        $resposta = Resposta::findOrFail($respostaId);

        $usuariosRelacionadosIds = Comentario::where('idResposta', $resposta->id)
            ->pluck('idUsuario')
            ->push($resposta->idUsuario)
            ->unique();

        // busca os usuários filtrando pelo termo
        $usuarios = User::whereIn('id', $usuariosRelacionadosIds)
            ->where('name', 'LIKE', "%{$termo}%")
            ->where('id', '!=', Auth::id())
            ->limit(10)
            ->get(['id', 'name']);


        return response()->json([
            'usuarios' => $usuarios,
            'userAuth' =>  Auth::user()
        ]);
    }

    /* Usuarios das mencoes*/
    /*public function usuariosDaResposta($idResposta)
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
    }*/
}
