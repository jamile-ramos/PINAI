<?php

namespace App\Http\Controllers;

use App\Models\CategoriaDocumento;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    public function index(){
        $categorias = CategoriaDocumento::where('status', 'ativo')->get();
        $documentos = Documento::where('status', 'ativo')->get();
        $myDocumentos = Documento::where('idUsuario', Auth::id())->where('status', 'ativo')->get();
        return view('documentos.index', compact('categorias', 'documentos', 'myDocumentos'));
    }

    public function create(){
        $categorias = CategoriaDocumento::where('status', 'ativo')->get();
        return view('documentos.form', compact('categorias'));
    }

    public function store(Request $request){
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

    public function edit(Request $request, $id){
        $documento= Documento::findOrFail($id);
        $categorias = CategoriaDocumento::where('status', 'ativo')->get();
        return view('documentos.form', compact('documento', 'categorias'));
    }

    public function update(Request $request, $id){
        $documento = Documento::findOrFail($id);

        if($request->hasFile('arquivo')){
            $caminho = $request->file('arquivo')->store('documentos', 'public');
        }else{
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

    public function documentosCategorias(Request $request, $idCategoria){
        $categoria = CategoriaDocumento::findOrFail($idCategoria);
        $documentos = $categoria->documentos()->where('status', 'ativo')->get();

        return view('documentos.documentosCategorias', compact('categoria', 'documentos'));
    }

    public function destroy(Request $request){
        $documento = Documento::findOrFail($request->id);
        $documento->update(['status' => 'inativo']);

        return redirect()->route('documentos.index')->with('success', 'Documento excluído com sucesso!');
    }
}
