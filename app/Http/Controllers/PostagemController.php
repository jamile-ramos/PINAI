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
    public function index($id)
    {
        $topico = Topico::findOrFail($id);
        $minhasPostagens = $this->myPostagens();
        $postagens = $topico->postagens()->withCount('respostas')->where('status', 'ativo')->get();
        return view('postagens.index', compact('postagens', 'minhasPostagens', 'topico'));
    }

    public function myPostagens()
    {
        $idUsuario = Auth::id();
        $minhasPostagens = Postagem::where('idUsuario', $idUsuario)->where('status', 'ativo')->get();
        return $minhasPostagens;
    }

    public function create($idTopico)
    {
        $topicos = Topico::all();
        return view('postagens.form', compact('topicos', 'idTopico'));
    }

    public function store(Request $request)
    {
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
        return redirect()->route('postagens.index', ['id' => $postagem->idTopico])->with('success', 'Postagem atualizada com sucesso!');
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
        $postagem = Postagem::with(['respostas' => function($query){
            $query->where('status', 'ativo');
        }])->findOrFail($id);
        //return view('postagens.show', compact('postagem', 'usuarios'));
        return view('postagens.show', compact('postagem'));
    }
}
