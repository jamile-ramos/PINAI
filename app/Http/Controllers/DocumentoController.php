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

        $paginaVisaoDocumentos = $request->input('documentos_page', 1);
        $paginaVisaoCategoriasDoc = $request->input('visaoCategoriasDoc_page', 1);
        $paginaMyDocumentos = $request->input('myDocumentos_page', 1);
        $paginaAllDocumentos = $request->input('allDocumentos_page', 1);
        $paginaCategoriaDocumentos = $request->input('categoriasDocumentos_page', 1);

        // Visão Documentos
        if ($query && $abaAtiva === 'visaoDocumentos') {
            $documentos = Documento::where('status', 'ativo')
                ->where(function ($q) use ($query) {
                    $q->where('nomeArquivo', 'like', '%' . $query . '%')
                        ->orWhere('descricao', 'like', '%' . $query . '%');
                })
                ->latest()
                ->paginate(9, ['*'], 'documentos_page', $paginaVisaoDocumentos)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
            $categorias = new LengthAwarePaginator(
                collect(),
                0,
                9,
                $paginaVisaoCategoriasDoc ?? 1,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        } else {
            $categorias = CategoriaDocumento::where('status', 'ativo')
                ->whereHas('documentos', function ($q) {
                    $q->where('status', 'ativo');
                })
                ->with(['documentos' => function ($q) {
                    $q->where('status', 'ativo')
                        ->latest()
                        ->take(3);
                }])
                ->paginate(5, ['*'], 'visaoCategoriasDoc_page', $paginaVisaoCategoriasDoc)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
            $documentos = new LengthAwarePaginator(
                collect(),
                0,
                9,
                $paginaVisaoDocumentos ?? 1,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        // Meus Documentos
        if ($query && $abaAtiva === 'myDocumentos') {
            $myDocumentos = Documento::where('status', 'ativo')
                ->where('idUsuario', Auth::user()->id)
                ->where(function ($q) use ($query) {
                    $q->where('nomeArquivo', 'like', '%' . $query . '%')
                        ->orWhere('descricao', 'like', '%' . $query . '%');
                })
                ->paginate(9, ['*'], 'myDocumentos_page', $paginaMyDocumentos)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else {
            $myDocumentos = Documento::where('status', 'ativo')
                ->where('idUsuario', Auth::user()->id)  
                ->paginate(9, ['*'], 'myDocumentos_page', $paginaMyDocumentos)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }

        // Gerenciar Documentos
        if ($query && $abaAtiva === 'allDocumentos') {
            $allDocumentos = Documento::where('status', 'ativo')
                ->where(function ($q) use ($query) {
                    $q->where('nomeArquivo', 'like', '%' . $query . '%')
                        ->orWhere('descricao', 'like', '%' . $query . '%');
                })
                ->with('user')
                ->paginate(9, ['*'], 'allDocumentos_page', $paginaAllDocumentos)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else {
            $allDocumentos = Documento::where('status', 'ativo')
                ->with('user')
                ->paginate(9, ['*'], 'allDocumentos_page', $paginaAllDocumentos)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }

        // Categorias
        if($query && $abaAtiva === 'categoriasDocumentos'){
            $categoriasDocumentos = CategoriaDocumento::where('status', 'ativo')
            ->where('nomeCategoria', 'like', '%' . $query . '%')
            ->paginate(10, ['*'], 'categoriasDocumentos_page', $paginaCategoriaDocumentos)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }else{
            $categoriasDocumentos = CategoriaDocumento::where('status', 'ativo')
            ->paginate(10, ['*'], 'categoriasDocumentos_page', $paginaCategoriaDocumentos);
        }

        return view('documentos.index', compact('categorias', 'documentos', 'allDocumentos', 'categoriasDocumentos', 'myDocumentos', 'abaAtiva', 'query'));
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
