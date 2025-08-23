<?php

namespace App\Http\Controllers;

use App\Models\Postagem;
use App\Models\Comentario;
use Illuminate\Http\Request;
use App\Models\Topico;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PostagemController extends Controller
{
    public function index($idTopico, Request $request)
    {
        $abaAtiva = $request->input('abaAtiva');
        $query = $request->input('query');

        $pages = [
            'visaoPostagens' => (int) $request->input('postagens_page', 1),
            'myPostagens' => (int) $request->input('myPostagens_page', 1),
            'allPostagens' => (int) $request->input('allPostagens_page', 1),
        ];

        // Visao Postagens
        if ($query && $abaAtiva === 'visaoPostagens') {
            $postagens = $this->buscarPostagensComQuery($idTopico, $query, $abaAtiva, $pages['visaoPostagens']);
        } else {
            $postagens = $this->buscarPostagensComQuery($idTopico, null, $abaAtiva, $pages['visaoPostagens']);
        }

        // Minhas Postagens
        if ($query && $abaAtiva === 'myPostagens') {
            $minhasPostagens = $this->buscarMinhasPostagens($idTopico, $query, $pages['myPostagens'], $abaAtiva);
        } else {
            $minhasPostagens = $this->buscarMinhasPostagens($idTopico, null, $pages['myPostagens'], $abaAtiva);
        }

        // Gerenciar Postagens
        if ($query && $abaAtiva === 'allPostagens') {
            $allPostagens = $this->buscarTodasPostagens($idTopico, $query, $pages['allPostagens'], $abaAtiva);
        } else {
            $allPostagens = $this->buscarTodasPostagens($idTopico, null, $pages['allPostagens'], $abaAtiva);
        }

        $topico = Topico::findOrFail($idTopico);
        return view('postagens.index', compact('postagens', 'allPostagens', 'minhasPostagens', 'topico', 'abaAtiva', 'query'));
    }

    public function buscarPostagensComQuery($idTopico, $query, $abaAtiva, $pagina)
    {

        $resultado = Postagem::where('idTopico', $idTopico)
            ->whereHas('topico', function ($q) {
                $q->ativos();
            });

        if (!empty($query)) {
            $resultado->where('titulo', 'like', '%' . $query . '%');
        }

        return $resultado->withCount('respostas')
            ->orderByDesc('updated_at')
            ->paginate(10, ['*'], 'postagens_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarMinhasPostagens($idTopico, $query, $pagina, $abaAtiva)
    {

        $resultado = Postagem::where('idTopico', $idTopico)
            ->where('idUsuario', Auth::user()->id)
            ->whereHas('topico', function ($q) {
                $q->ativos();
            });

        if (!empty($query)) {
            $resultado->where('titulo', 'like', '%' . $query . '%');
        }

        return $resultado->orderByDesc('created_at')
            ->paginate(10, ['*'], 'myPostagens_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarTodasPostagens($idTopico, $query, $pagina, $abaAtiva)
    {
        $resultado = Postagem::ativos()
            ->where('idTopico', $idTopico)
            ->whereHas('topico', function ($q) {
                $q->ativos();
            });

        if (!empty($query)) {
            $resultado->where(function ($q) use ($query) {
                $q->where('titulo', 'like', '%' . $query . '%')
                    ->orWhereHas('user', function ($sub) use ($query) {
                        $sub->where('name', 'like', '%' . $query . '%');
                    });
            });
        }

        return $resultado->paginate(10, ['*'], 'allPostagens_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

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

        //upload Postagem
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImage = $request->file('imagem');
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now') . $extension);
            $requestImage->move(public_path('img/imgPostagens'), $imageName);
            $postagem->imagem = $imageName;
        }
        $postagem->save();

        return redirect()->route('postagens.index', $postagem->idTopico)->with('success', 'Postagem criada com sucesso!');
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
        //upload Postagem
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImage = $request->file('imagem');
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now') . $extension);
            $requestImage->move(public_path('img/imgPostagens'), $imageName);
            $data['imagem'] = $imageName;
        }
        $postagem = Postagem::findOrFail($id);
        $postagem->update($data);
        return redirect()->route('postagens.index', ['idTopico' => $postagem->idTopico])->with('success', 'Postagem atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $postagem = Postagem::findOrFail($id);
        $postagem->update(['status' => 'inativo']);
        return back()->with('success', 'Postagem excluída com sucesso!');
    }

    public function show($id)
    {
        //$usuarios = User::all();
        $postagem = Postagem::with([
            'respostas' => function ($query) {
                $query->where('status', 'ativo')
                ->with(['comentarios' => function ($q){
                    $q->where('status', 'ativo');
                }]);
            }
        ])->findOrFail($id);
        //return view('postagens.show', compact('postagem', 'usuarios'));
        return view('postagens.show', compact('postagem'));
    }
}
