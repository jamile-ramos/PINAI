<?php

namespace App\Http\Controllers;

use App\Models\CategoriaSolucao;
use App\Models\Solucao;
use App\Models\PublicoAlvo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolucaoController extends Controller
{
    public function index(){
        $categorias = CategoriaSolucao::where('status', 'ativo')->get();
        return view('solucoes.index', compact('categorias'));
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
            'idCategoria' => 'required|integer'
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
}
