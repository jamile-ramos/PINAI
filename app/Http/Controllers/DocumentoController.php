<?php

namespace App\Http\Controllers;

use App\Models\CategoriaDocumento;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DocumentoController extends Controller
{
    public function index(Request $request)
    {

        $abaAtiva = $request->input('abaAtiva');
        $query = $request->input('query');

        $pages = [
            'visaoDocumentos' => $request->input('documentos_page', 1),
            'visaoCategoriasDoc' => $request->input('visaoCategoriasDoc_page', 1),
            'myDocumentos' => $request->input('myDocumentos_page', 1),
            'allDocumentos' => $request->input('allDocumentos_page', 1),
            'categoriasDocumentos' => $request->input('categoriasDocumentos_page', 1),
        ];

        // Visão Documentos
        if ($query && $abaAtiva === 'visaoDocumentos') {
            $documentos = $this->buscarDocumentosComQuery($query, $pages['visaoDocumentos'], $abaAtiva);
            $categorias = $this->paginaVazia(9, $pages['visaoCategoriasDoc']);
        } else {
            $categorias = $this->buscarCategoriasDocumentos(null, $pages['visaoCategoriasDoc'], $abaAtiva);
            $documentos = $this->paginaVazia(9, $pages['visaoCategoriasDoc']);
        }

        // Meus Documentos
        if ($query && $abaAtiva === 'myDocumentos') {
            $myDocumentos = $this->buscarMeusDocumentos($query, $pages['myDocumentos'], $abaAtiva);
        } else {
            $myDocumentos = $this->buscarMeusDocumentos(null, $pages['myDocumentos'], $abaAtiva);
        }

        // Gerenciar Documentos
        if ($query && $abaAtiva === 'allDocumentos') {
            $allDocumentos = $this->buscarTodosDocumentos($query, $pages['allDocumentos'], $abaAtiva);
        } else {
            $allDocumentos = $this->buscarTodosDocumentos(null, $pages['allDocumentos'], $abaAtiva);
        }

        // Categorias
        if ($query && $abaAtiva === 'categoriasDocumentos') {
            $categoriasDocumentos = $this->buscarCategoriasDocumentos($query, $pages['categoriasDocumentos'], $abaAtiva);
        } else {
            $categoriasDocumentos = $this->buscarCategoriasDocumentos(null, $pages['categoriasDocumentos'], $abaAtiva);
        }

        return view('documentos.index', compact('categorias', 'documentos', 'allDocumentos', 'categoriasDocumentos', 'myDocumentos', 'abaAtiva', 'query'));
    }

    public function buscarDocumentosComQuery($query, $pagina, $abaAtiva)
    {
        $resultados = Documento::ativos();

        if (!empty($query)) {
            $resultados->where(function ($q) use ($query) {
                $q->where('nomeArquivo', 'like', '%' . $query . '%')
                    ->orWhere('descricao', 'like', '%' . $query . '%');
            });
        }

        return $resultados->latest()
            ->paginate(9, ['*'], 'documentos_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarCategoriasDocumentos($query, $pagina, $abaAtiva)
    {
        $resultado = CategoriaDocumento::ativos();

        // Se estiver na aba de categorias com busca
        if (!empty($query) && $abaAtiva === 'categoriasDocumentos') {
            $resultado->where('nomeCategoria', 'like', '%' . $query . '%');
        }else{
            $resultado->whereHas('documentos', function ($q) {
                $q->ativos();
            })
            ->with(['documentos' => function ($q) {
                $q->ativos()
                    ->latest()
                    ->take(3);
            }]);
        }

        return $resultado->paginate($abaAtiva === 'categoriasDocumentos' ? 5 : 10, ['*'], $abaAtiva === 'categoriasDocumentos' ? 'categoriasDocumentos_page' : 'visaoCategoriasDoc_page', $pagina)
        ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarMeusDocumentos($query, $pagina, $abaAtiva)
    {
        $resultados = Documento::ativos()
            ->where('idUsuario', Auth::user()->id);

        if (!empty($query)) {
            $resultados->where(function ($q) use ($query) {
                $q->where('nomeArquivo', 'like', '%' . $query . '%')
                    ->orWhere('descricao', 'like', '%' . $query . '%');
            });
        }

        return $resultados->paginate(9, ['*'], 'myDocumentos_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarTodosDocumentos($query, $pagina, $abaAtiva)
    {
        $resultados = Documento::ativos();

        if (!empty($query)) {
            $resultados->where(function ($q) use ($query) {
                $q->where('nomeArquivo', 'like', '%' . $query . '%')
                    ->orWhere('descricao', 'like', '%' . $query . '%');
            });
        }

        return $resultados->with('user')
            ->paginate(9, ['*'], 'allDocumentos_page', $pagina)
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
        $categorias = CategoriaDocumento::where('status', 'ativo')->get();
        return view('documentos.form', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomeArquivo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'idCategoria' => 'required|exists:categorias_documentos,id',
            'arquivo' => 'required|file|mimes:pdf|max:20480', //10mb
        ]);

        $caminho = $request->file('arquivo')->store('documentos', 'public');

        Documento::create([
            'nomeArquivo' => $request->nomeArquivo,
            'descricao' => $request->descricao,
            'idCategoria' => $request->idCategoria,
            'caminhoArquivo' => $caminho,
            'idUsuario' => Auth::id()
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento adicionado com sucesso!');
    }

    public function edit(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);
        $categorias = CategoriaDocumento::where('status', 'ativo')->get();
        return view('documentos.form', compact('documento', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);

        if ($request->hasFile('arquivo')) {
            $caminho = $request->file('arquivo')->store('documentos', 'public');
        } else {
            $caminho = $documento->caminhoArquivo;
        }

        $documento->update([
            'nomeArquivo' => $request->nomeArquivo,
            'descricao' => $request->descricao,
            'idCategoria' => $request->idCategoria,
            'caminhoArquivo' => $caminho,
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento atualizado com sucesso!');
    }

    public function documentosCategorias(Request $request, $idCategoria)
    {
        $categoria = CategoriaDocumento::findOrFail($idCategoria);
        $documentos = $categoria->documentos()->where('status', 'ativo')->get();

        return view('documentos.documentosCategorias', compact('categoria', 'documentos'));
    }

    public function destroy(Request $request)
    {
        $documento = Documento::findOrFail($request->id);
        $documento->update(['status' => 'inativo']);

        return redirect()->route('documentos.index')->with('success', 'Documento excluído com sucesso!');
    }
}
