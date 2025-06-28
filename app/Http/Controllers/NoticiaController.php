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

        $pages = [
            'visaoNoticias' => $request->input('noticias_page', 1),
            'categoriasNoticias' => $request->input('categoriasNoticias_page', 1),
            'myNoticias' => $request->input('myNoticias_page', 1),
            'allNoticias' => $request->input('allNoticias_page', 1),
            'visaoCategoriasNoticias' => $request->input('visaoCategoriasNoticias_page', 1),
        ];

        // Visão Noticias
        if ($query && $abaAtiva === 'visaoNoticias') {
            $noticiasBusca = $this->buscarNoticiasComQuery($query, $pages['visaoNoticias'], $abaAtiva);
            $categorias = $this->paginaVazia(10, $pages['visaoCategoriasNoticias']);
        } else {
            $categorias = $this->buscarCategoriasNoticias(null, $pages['visaoCategoriasNoticias'], $abaAtiva);
            $noticiasBusca = $this->paginaVazia(10, $pages['visaoNoticias']);
        }

        // Minhas Noticias
        if ($query && $abaAtiva === 'myNoticias') {
            $minhasNoticias = $this->buscarMinhasNoticias($query, $pages['myNoticias'], $abaAtiva);
        } else {
            $minhasNoticias = $this->buscarMinhasNoticias(null, $pages['myNoticias'], $abaAtiva);
        }

        // Gerenciar Noticias
        if ($query && $abaAtiva === 'allNoticias') {
            $noticias = $this->buscarTodasNoticias($query, $pages['allNoticias'], $abaAtiva);
        } else {
            $noticias = $this->buscarTodasNoticias(null, $pages['allNoticias'], $abaAtiva);
        }

        // Categorias
        if ($query && $abaAtiva === 'categoriasNoticias') {
            $categoriasNoticias = $this->buscarCategoriasNoticias($query, $pages['categoriasNoticias'], $abaAtiva);
        } else {
            $categoriasNoticias = $this->buscarCategoriasNoticias(null, $pages['categoriasNoticias'], $abaAtiva); 
        }

        $noticiasRecentes = Noticia::where('status', 'ativo')->latest()->take(3)->get();
        return view('noticias.index', compact('noticias', 'categorias', 'categoriasNoticias', 'minhasNoticias', 'noticiasRecentes', 'noticiasBusca', 'query', 'abaAtiva'));
    }
    
    public function buscarNoticiasComQuery($query, $pagina, $abaAtiva)
    {
        return Noticia::ativos()
            ->where(function ($q) use ($query) {
                $q->where('titulo', 'like', '%' . $query . '%')
                    ->orWhere('subtitulo', 'like', '%' . $query . '%');
            })
            ->paginate(10, ['*'], 'noticias_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarCategoriasNoticias($query, $pagina, $abaAtiva)
    {
        return CategoriaNoticia::ativos()
        ->where('nomeCategoria', 'like', '%' . $query . '%')
            ->whereHas('noticias', function ($q) {
                $q->ativos();
            })
            ->with(['noticias' => function ($q) {
                $q->ativos()
                    ->latest()
                    ->take(3);
            }])
            ->paginate(10, ['*'], 'visaoCategoriasNoticias_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarMinhasNoticias($query, $pagina, $abaAtiva)
    {
        return Noticia::ativos()
            ->with('categoria')
            ->where('idUsuario', Auth::user()->id)
            ->where(function ($q) use ($query) {
                $q->where('titulo', 'like', '%' . $query . '%')
                    ->orWhereHas('categoria', function ($sub) use ($query) {
                        $sub->where('nomeCategoria', 'like', '%' . $query . '%');
                    });
            })
            ->paginate(10, ['*'], 'myNoticias_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarTodasNoticias($query, $pagina, $abaAtiva)
    {
        return Noticia::ativos()
            ->with('categoria')
            ->where(function ($q) use ($query) {
                $q->where('titulo', 'like', '%' . $query . '%')
                    ->orWhereHas('categoria', function ($sub) use ($query) {
                        $sub->where('nomeCategoria', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('user', function ($sub) use ($query) {
                        $sub->where('name', 'like', '%' . $query . '%');
                    });
            })
            ->paginate(10, ['*'], 'allNoticias_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function paginaVazia($itensPorPagina, $pagina)
    {
        return new LengthAwarePaginator(
            collect([]),
            0,
            $itensPorPagina,
            $pagina,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
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
