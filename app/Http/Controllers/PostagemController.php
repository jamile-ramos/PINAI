<?php

namespace App\Http\Controllers;

use App\Events\ConteudoExcluido;
use App\Events\PostagemCriada;
use App\Models\Postagem;
use App\Models\Comentario;
use Illuminate\Http\Request;
use App\Models\Topico;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Concerns\EnforcesCorrectSlug;
use App\Notifications\NovaPostagemNotification;
use Illuminate\Support\Facades\Notification;

class PostagemController extends Controller
{

    public function create($idTopico)
    {
        $topicos = Topico::all();
        return view('postagens.form', compact('topicos', 'idTopico'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'idTopico' => 'required|exists:topicos,id'
        ]);

        $postagem = new Postagem;

        $postagem->titulo = $request->titulo;
        $postagem->conteudo = $request->conteudo;
        $postagem->idTopico = $request->idTopico;
        $postagem->idUsuario = Auth::user()->id;

         $postagem->save();

        // Notificação via email
        $topico = Topico::findOrFail($postagem->idTopico);
        event(new PostagemCriada($postagem));

        // Notificação do site
        $destinatarios = User::where('id', '!=', Auth::id())->get();
        Notification::send($destinatarios, new NovaPostagemNotification($postagem));


        return redirect()->route('topicos.show', ['id' => $postagem->idTopico, 'slug' => $topico->slug])->with('success', 'Postagem criada com sucesso!');
    }

    public function edit($id)
    {
        $postagem = Postagem::findOrFail($id);
        $topicos = Topico::all();
        return view('postagens.form', compact('postagem', 'topicos'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $postagem = Postagem::findOrFail($id);
        $postagem->update($data);

        $topico = Topico::findOrFail($postagem->idTopico);
        return redirect()->route('topicos.show', ['id' => $postagem->idTopico, 'slug' => $topico->slug])->with('success', 'Postagem atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $postagem = Postagem::findOrFail($id);
        $postagem->update(['status' => 'inativo']);
        event(new ConteudoExcluido($postagem->titulo, 'postagem'));
        return back()->with('success', 'Postagem excluída com sucesso!');
    }

    use EnforcesCorrectSlug;

    public function show($id, $slug)
    {
        //$usuarios = User::all();
        $postagem = Postagem::with([
            'respostas' => function ($query) {
                $query->where('status', 'ativo')
                    ->with(['comentarios' => function ($q) {
                        $q->where('status', 'ativo')
                            ->with(['user', 'mencoes']);
                    }]);
            }
        ])->findOrFail($id);

        if ($r = $this->redirectIfWrongSlug($postagem, $slug, 'postagens.show')) {
            return $r;
        }

        //return view('postagens.show', compact('postagem', 'usuarios'));
        return view('postagens.show', compact('postagem'));
    }
}
