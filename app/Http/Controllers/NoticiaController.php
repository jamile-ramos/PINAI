<?php

namespace App\Http\Controllers;

use App\Models\CategoriaNoticia;
use App\Models\Noticia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    public function index()
    {
        $categorias = CategoriaNoticia::all();
        $minhasNoticias = $this->myNoticias();
        $noticias = Noticia::all();
        $noticiasRecentes = Noticia::latest()->take(3)->get();
        return view('noticias.index', compact('noticias', 'categorias', 'minhasNoticias', 'noticiasRecentes'));
    }

    public function myNoticias()
    {
        $idUsuario = Auth::user()->id;
        $minhasNoticias = Noticia::where('idUsuario', $idUsuario)->get();
        return $minhasNoticias;
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
        $noticia->idCategoria = $request->idCategoria;
        $noticia->idUsuario = Auth::id();

        //upload Noticia
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImage = $request->file('imagem');
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now') . $extension);
            $requestImage->move(public_path('img/imgNoticias'), $imageName);
            $noticia->imagem = $imageName;
        }
        $noticia->save();

        return redirect()->route('noticias.index')->with('success', 'Notícia criada com sucesso!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        Noticia::destroy($id);
        return redirect()->route('noticias.index')->with('success', 'Notícia excluída com sucesso!');
    }

    public function edit($id)
    {
        $noticia = Noticia::findOrFail($id);
        $categorias = CategoriaNoticia::all();
        return view('noticias.create', compact('categorias', 'noticia'));

    }

    public function update(Request $request, $id)
{
    $data = $request->all();

    // Upload da imagem
    if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
        $requestImage = $request->file('imagem');
        $extension = $requestImage->extension();
        $imageName = md5($requestImage->getClientOriginalName() . strtotime('now') . $extension);
        $requestImage->move(public_path('img/imgNoticias'), $imageName);
        $data['imagem'] = $imageName;
    }

    // Atualizando os dados da notícia
    Noticia::findOrFail($id)->update($data); // Usando o array $data que inclui a imagem
    return redirect()->route('noticias.index')->with('success', 'Notícia atualizada com sucesso!');
}

}
