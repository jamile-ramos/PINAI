<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('noticias.index', compact('noticias'));
    }

    public function store(Request $request)
    {
        $noticia = new Noticia;

        $noticia->titulo = $request->titulo;
        $noticia->subtitulo = $request->subtitulo;
        $noticia->conteudo = $request->conteudo;
        $noticia->idCategoriaNoticia = $request->categoria;
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

        return redirect('/noticias');
    }
}
