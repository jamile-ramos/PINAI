<?php

namespace App\Http\Controllers;

use App\Models\Postagem;
use App\Models\Comentario;
use Illuminate\Http\Request;
use App\Models\Topico;
use Illuminate\Support\Facades\Auth;

class PostagemController extends Controller
{
    public function index($id)
    {
        $topico = Topico::findOrFail($id);
        $minhasPostagens = $this->myPostagens();
        $postagens = $topico->postagens()->withCount('respostas')->get();
        return view('postagens.index', compact('postagens', 'minhasPostagens'));
    }

    public function myPostagens()
    {
        $idUsuario = Auth::id();
        $minhasPostagens = Postagem::where('idUsuario', $idUsuario)->get();
        return $minhasPostagens;
    }

    public function create()
    {
        $topicos = Topico::all();
        return view('postagens.form', compact('topicos'));
    }

    public function store(Request $request)
    {
        $postagem = new Postagem;

        $postagem->titulo = $request->titulo;
        $postagem->conteudo = $request->conteudo;
        $postagem->idTopico = $request->idTopico;
        $postagem->idUsuario = Auth::user()->id;

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

        Postagem::findOrFail($id)->update($data);
        return redirect()->route('postagens.index', $id)->with('success', 'Postagem atualizada com sucesso!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        Postagem::destroy($id);
        return back()->with('success', 'Postagem excluída com sucesso!');
    }

    public function show($id)
    {
        $postagem = Postagem::with(['respostas.comentarios'])->findOrFail($id);
        return view('postagens.show', compact('postagem'));
    }
}
