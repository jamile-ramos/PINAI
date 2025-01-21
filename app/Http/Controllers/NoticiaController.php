<?php

namespace App\Http\Controllers;

use App\Models\CategoriaNoticia;
use App\Models\Noticia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class NoticiaController extends Controller
{
    public function index()
    {
        $query = request('query');
        if ($query) {
            $noticias = Noticia::where([
                ['title', 'like', '%' . $query . '%']
            ]);
        } else {
            $noticias = Noticia::all();
        }
        $user = Auth::user();
        return view('noticias.index', compact('noticias', 'user'));
    }

    public function create()
    {
        $categorias = CategoriaNoticia::all();
        return view('noticias.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $noticia = new Noticia;
        $noticia->titulo = $request->titulo;
        $noticia->subtitulo = $request->subtitulo;
        $noticia->conteudo = $request->conteudo;
        $noticia->idCategoria = $request->categoria;
        $noticia->idUsuario = Auth::id();

        // Image upload
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImage = $request->file('imagem');
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now') . $extension);
            $requestImage->move(public_path('img/imgNoticias'), $imageName);
            $noticia->imagem = $imageName;
        }
        $noticia->save();
        $noticias = Noticia::all();
        $user = Auth::user();
        return view('noticias.index', compact('noticias', ('user')))->with('sucess', 'Notícia criada com sucesso!');
    }

    public function edit($id)
    {
        $noticia = Noticia::findOrFail($id);
        $categorias = CategoriaNoticia::all();
        return view('noticias.edit', compact('noticia', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImage = $request->file('imagem');
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now') . $extension);
            $requestImage->move(public_path('img/imgNoticias'), $imageName);
            $data['imagem'] = $imageName;
        }

        $noticia = Noticia::findOrFail($id);
        $noticia->update($data);
        $noticias = Noticia::all();
        return view('noticias.index', compact('noticias'));
    }

    public function minhasNoticias($idUsuario)
    {
        $user = User::findOrFail($idUsuario);
        $noticias = $user->noticias;
        return view('noticias.minhasNoticias', compact('noticias'));
    }

    public function delete($id)
    {
        Noticia::destroy($id);
        $noticias = Noticia::all();
        return view('noticias.minhasNoticias', compact('noticias'));
    }
}
