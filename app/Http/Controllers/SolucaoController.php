<?php

namespace App\Http\Controllers;

use App\Models\CategoriaSolucao;
use App\Models\Solucao;
use App\Models\PublicoAlvo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Ramsey\Uuid\v1;

class SolucaoController extends Controller
{
    public function index(){
        $categorias = CategoriaSolucao::where('status', 'ativo')->get();
        $solucoes = Solucao::where('status', 'ativo')->get();
        $mySolucoes = Solucao::where('status', 'ativo')->where('idUsuario', Auth::user()->id)->get();
        return view('solucoes.index', compact('categorias', 'solucoes', 'mySolucoes'));
    }

    public function create(){
        $categorias = CategoriaSolucao::where('status', 'ativo')->get();
        $publicosAlvo = PublicoAlvo::where('status', 'ativo')->get();
        return view('solucoes.form', compact('categorias', 'publicosAlvo'));
    }

    public function store(Request $request){
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'passosImplementacao' => 'required|string',
            'publicos_alvo' => 'required|array',
            'publicos_alvo.*' => 'integer|exists:publicos_alvo,id',
            'idCategoria' => 'required|integer',
            'arquivo' => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);

        if($request->hasFile('arquivo')){
            $caminho = $request->file('arquivo')->store('documentos', 'public');
        }else{
            $caminho = null;
        }

        $solucao = Solucao::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'passosImplementacao' => $request->passosImplementacao,
            'arquivo' => $caminho,
            'idCategoria' => $request->idCategoria,
            'idUsuario' => Auth::user()->id
        ]);

        $solucao->publicosAlvo()->attach($request->publicos_alvo);

        return redirect()->route('solucoes.index')->with('success', 'Solução criada com sucesso!');
    }

    public function show($id){
        $solucao = Solucao::findOrFail($id);
        return view('solucoes.show', compact('solucao'));
    }

    public function edit($id){
        $solucao = Solucao::findOrFail($id);
        $publicosAlvo = PublicoAlvo::where('status', 'ativo')->get();
        $categorias = CategoriaSolucao::where('status', 'ativo')->get();
        return view('solucoes.form', compact('solucao', 'publicosAlvo', 'categorias'));
    }

    public function update(Request $request, $id){
        $solucao =  Solucao::findOrFail($id);

        if($request->hasFile('arquivo')){
            $caminho = $request->file('arquivo')->store('documentos', 'public');
        }else{
            $caminho = $solucao->arquivo;
        }

        $solucao->update([
            'titulo' => $solucao->titulo,
            'descricao' => $solucao->descricao,
            'passosImplementacao' => $solucao->passosImplementacao,
            'arquivo' => $caminho,
            'idCategoria' => $solucao->idCategoria,
            'idUsuario' => Auth::user()->id
        ]);
        
        $solucao->publicosAlvo()->sync($request->publicos_alvo);
        return redirect()->route('solucoes.index')->with('success', 'Solução atualizada com sucesso!');
    }

    public function destroy(Request $request){
        $solucao = Solucao::findOrFail($request->id);
        $solucao->status = 'inativo';
        $solucao->save();

        return redirect()->route('solucoes.index')->with('success', 'Solução excluída com sucesso!');
    }

    public function solucoesCategorias($idCategoria){
        $categoria = CategoriaSolucao::findOrFail($idCategoria);
        $solucoes = $categoria->solucoes()->where('status', 'ativo')->get();
        return view('solucoes.solucoesCategorias', compact('solucoes', 'categoria'));
    }
}
