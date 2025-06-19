<?php

namespace App\Http\Controllers;

use App\Models\CategoriaNoticia;
use App\Models\Noticia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $abaAtiva = $request->input('abaAtiva');

        $paginaVisaoNoticias = $request->input('noticias_page',1);
        $paginaMyNoticias = $request->input('myNoticias_page', 1);
        $paginaAllNoticias = $request->input('allNoticias_page', 1);
        $paginaCategorias = $request->input('categorias_page', 1);
        $noticiasBusca = collect();

        if ($query && $abaAtiva === 'visaoNoticias') {
            $noticiasBusca = Noticia::where('status', 'ativo')
                ->where(function ($q) use ($query) {
                    $q->where('titulo', 'like','%'. $query . '%')
                        ->orwhere('subtitulo', 'like', '%' .$query . '%');
                })
                ->paginate(10, ['*'], 'noticias_page', $paginaVisaoNoticias)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }

        $noticias = Noticia::where('status', 'ativo')->get();
        $categorias = CategoriaNoticia::where('status', 'ativo')->get();
        $minhasNoticias = $this->myNoticias();
        $noticiasRecentes = Noticia::where('status', 'ativo')->latest()->take(3)->get();
        return view('noticias.index', compact('noticias', 'categorias', 'minhasNoticias', 'noticiasRecentes', 'noticiasBusca', 'query'));
    }

    public function myNoticias()
    {
        $idUsuario = Auth::user()->id;
        $minhasNoticias = Noticia::where('idUsuario', $idUsuario)->where('status', 'ativo')->get();
        return $minhasNoticias;
    }

    public function create()
    {
        $categorias = CategoriaNoticia::all();
        return view('noticias.form', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'idCategoria' => 'required|exists:categorias_noticias,id',
            'imagem' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

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

    public function destroy(Request $request)
    {
        $noticia = Noticia::findOrFail($request->id);
        $noticia->update(['status' => 'inativo']);

        return redirect()->route('noticias.index')->with('success', 'Notícia excluída com sucesso!');
    }


    public function edit($id)
    {
        $noticia = Noticia::findOrFail($id);
        $categorias = CategoriaNoticia::all();
        return view('noticias.form', compact('categorias', 'noticia'));
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
        Noticia::findOrFail($id)->update($data);
        return redirect()->route('noticias.index')->with('success', 'Notícia atualizada com sucesso!');
    }

    public function show($id)
    {
        $noticia = Noticia::findOrFail($id);
        return view('noticias.show', compact('noticia'));
    }

    public function noticiasCategorias($idCategoria)
    {
        $categoria = CategoriaNoticia::findOrFail($idCategoria);
        $noticias = $categoria->noticias()->where('status', 'ativo')->get();

        return view('noticias.noticiasCategorias', compact('noticias', 'categoria'));
    }
}
