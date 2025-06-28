<?php

namespace App\Http\Controllers;

use App\Models\CategoriaNoticia;
use App\Models\Noticia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class NoticiaController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $abaAtiva = $request->input('abaAtiva');

        $paginaVisaoNoticias = $request->input('noticias_page', 1);
        $paginaMyNoticias = $request->input('myNoticias_page', 1);
        $paginaAllNoticias = $request->input('allNoticias_page', 1);
        $paginaCategoriaNoticias = $request->input('categoriasNoticias_page',1);

        // Visão Noticias
        if ($query && $abaAtiva === 'visaoNoticias') {
            $noticiasBusca = Noticia::where('status', 'ativo')
                ->where(function ($q) use ($query) {
                    $q->where('titulo', 'like', '%' . $query . '%')
                        ->orWhere('subtitulo', 'like', '%' . $query . '%');
                })
                ->paginate(10, ['*'], 'noticias_page', $paginaVisaoNoticias)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }else{
            // Criar um paginator vazio para evitar erros
            $emptyCollection = collect([]);
            $noticiasBusca = new LengthAwarePaginator(
                $emptyCollection,
                0,
                10,
                $paginaVisaoNoticias,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
        }

        // Minhas Noticias
        if ($query && $abaAtiva === 'myNoticias') {
            $minhasNoticias = Noticia::with('categoria')
                ->where('status', 'ativo')
                ->where('idUsuario', Auth::user()->id)
                ->where(function ($q) use ($query) {
                    $q->where('titulo', 'like', '%' . $query . '%')
                        ->orWhereHas('categoria', function ($sub) use ($query) {
                            $sub->where('nomeCategoria', 'like', '%' . $query . '%');
                        });
                })
                ->paginate(10, ['*'], 'myNoticias_page', $paginaMyNoticias)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else {
            $minhasNoticias = Noticia::where('status', 'ativo')
            ->where('idUsuario', Auth::user()->id)
            ->paginate(10, ['*'], 'myNoticias_page', $paginaMyNoticias);
        }

        // Gerenciar Noticias
        if ($query && $abaAtiva === 'allNoticias') {
            $noticias = Noticia::with('categoria')
                ->where('status', 'ativo')
                ->where(function ($q) use ($query) {
                    $q->where('titulo', 'like', '%' . $query . '%')
                        ->orWhereHas('categoria', function ($sub) use ($query) {
                            $sub->where('nomeCategoria', 'like', '%' . $query . '%');
                        })
                        ->orWhereHas('user', function($sub) use($query){
                            $sub->where('name', 'like', '%' . $query . '%');
                        });
                })
                ->paginate(10, ['*'], 'allNoticias_page', $paginaAllNoticias)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else {
            $noticias = Noticia::where('status', 'ativo')
            ->paginate(10, ['*'], 'allNoticias_page', $paginaAllNoticias);
        }

        // Categorias
        if($query && $abaAtiva === 'categoriasNoticias'){
            $categorias = CategoriaNoticia::where('status', 'ativo')
            ->where('nomeCategoria', 'like', '%' . $query . '%')
            ->paginate(10, ['*'], 'categoriasNoticias_page', $paginaCategoriaNoticias)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }else{
            $categorias = CategoriaNoticia::where('status', 'ativo')
            ->paginate(10, ['*'], 'categoriasNoticias_page', $paginaCategoriaNoticias);
        }

        $noticiasRecentes = Noticia::where('status', 'ativo')->latest()->take(3)->get();
        return view('noticias.index', compact('noticias', 'categorias', 'minhasNoticias', 'noticiasRecentes', 'noticiasBusca', 'query', 'abaAtiva'));
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
