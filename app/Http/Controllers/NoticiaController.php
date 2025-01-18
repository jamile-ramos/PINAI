<?php

namespace App\Http\Controllers;

use App\Models\CategoriaNoticia;
use App\Models\Noticia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticiaController extends Controller
{
    public function index(){
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

    public function create(){
        $categorias = CategoriaNoticia::all();
        return view('noticias.create', compact('categorias'));
    }

    public function store(Request $request){
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
        return view('noticias.index', compact('noticias', ('user')));
    }

    public function edit($id){
        $noticia = Noticia::findOrFail($id);
        return view('noticias.edit', compact('noticia'));
    }

    public function update(Request $request, $id) {
        $noticia = Noticia::findOrFail($id);

        $noticia->titulo = $request->input('titulo');
        $noticia->subtitulo = $request->input('subtitulo');
        $noticia->conteudo = $request->input('conteudo');
        $noticia->categoria = $request->input('categoria'); 

    }

    public function minhasNoticias($idUsuario){
        $user = User::findOrFail($idUsuario);
        $noticias = $user->noticias;
        return view('noticias.minhasNoticias', compact('noticias'));
    }

    public function delete($id){
        Noticia::destroy($id);
        $noticias = Noticia::all();
        return view('noticias.minhasNoticias', compact('noticias'));
    }
}
