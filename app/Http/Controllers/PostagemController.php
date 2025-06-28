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

        $paginaVisaoPostagens = $request->input('postagens_page', 1);
        $paginaMyPostagens = $request->input('myPostagens_page', 1);
        $paginaAllPostagens = $request->input('allPostagens_page', 1);

        // Visao Postagens
        if ($query && $abaAtiva === 'visaoPostagens') {
            $postagens = Postagem::where('idTopico', $idTopico)
                ->where('titulo', 'like', '%' . $query . '%')
                ->whereHas('topico', function ($q) use ($query) {
                    $q->where('status', 'ativo');
                })
                ->withCount('respostas')
                ->orderByDesc('updated_at')
                ->paginate(10, ['*'], 'postagens_page', $paginaVisaoPostagens)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else {
            $postagens = Postagem::where('idTopico', $idTopico)
                ->whereHas('topico', function ($q) use ($query) {
                    $q->where('status', 'ativo');
                })
                ->withCount('respostas')
                ->orderByDesc('updated_at')
                ->paginate(10, ['*'], 'postagens_page', $paginaVisaoPostagens)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }

        // Minhas Postagens
        if ($query && $abaAtiva === 'myPostagens') {
            $minhasPostagens = Postagem::where('idTopico', $idTopico)
                ->where('idUsuario', Auth::user()->id)
                ->where('titulo', 'like', '%' . $query . '%')
                ->whereHas('topico', function ($q) use ($query) {
                    $q->where('status', 'ativo');
                })
                ->orderByDesc('created_at')
                ->paginate(10, ['*'], 'myPostagens_page', $paginaMyPostagens)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else {
            $minhasPostagens = Postagem::where('idTopico', $idTopico)
                ->where('idUsuario', Auth::user()->id)
                ->whereHas('topico', function ($q) use ($query) {
                    $q->where('status', 'ativo');
                })
                ->orderByDesc('created_at')
                ->paginate(10, ['*'], 'myPostagens_page', $paginaMyPostagens)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }

        // Gerenciar Postagens
        if ($query && $abaAtiva === 'allPostagens') {
            $allPostagens = Postagem::where('idTopico', $idTopico)
                ->whereHas('topico', function ($q) use ($query) {
                    $q->where('status', 'ativo');
                })
                ->where(function ($q) use ($query) {
                    $q->where('titulo', 'like', '%' . $query . '%')
                        ->orWhereHas('user', function ($sub) use ($query) {
                            $sub->where('name', 'like', '%' . $query . '%');
                        });
                })
                ->paginate(10, ['*'], 'allPostagens_page', $paginaAllPostagens)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else {
            $allPostagens = Postagem::where('idTopico', $idTopico)
                ->whereHas('topico', function ($q) use ($query) {
                    $q->where('status', 'ativo');
                })
                ->orderByDesc('updated_at')
                ->paginate(10, ['*'], 'allPostagens_page', $paginaAllPostagens)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }

        $topico = Topico::findOrFail($idTopico);
        return view('postagens.index', compact('postagens', 'allPostagens', 'minhasPostagens', 'topico', 'abaAtiva', 'query'));
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

    public function destroy(Request $request)
    {
        $postagem = Postagem::findOrFail($request->id);
        $postagem->update(['status' => 'inativo']);
        return back()->with('success', 'Postagem excluída com sucesso!');
    }

    public function show($id)
    {
        //$usuarios = User::all();
        $postagem = Postagem::with(['respostas' => function ($query) {
            $query->where('status', 'ativo');
        }])->findOrFail($id);
        //return view('postagens.show', compact('postagem', 'usuarios'));
        return view('postagens.show', compact('postagem'));
    }
}
