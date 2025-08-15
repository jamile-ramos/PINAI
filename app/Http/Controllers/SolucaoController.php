<?php

namespace App\Http\Controllers;

use App\Models\CategoriaSolucao;
use App\Models\Solucao;
use App\Models\PublicoAlvo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Node\Expr\FuncCall;

class SolucaoController extends Controller
{
    public function index(Request $request)
    {

        $abaAtiva = $request->input('abaAtiva');
        $query = $request->input('query');

        $pages = [
            'visaoSolucoes' => $request->input('solucoes_page', 1),
            'visaoCategoriasSol' => $request->input('visaoCategoriasSol_page', 1),
            'mySolucoes' => $request->input('mySolucoes_page', 1),
            'allSolucoes' => $request->input('allSolucoes_page', 1),
            'categoriasSolucoes' => $request->input('categoriasSolucoes_page', 1)
        ];

        $paginaVisaoSolucoes = $request->input('solucoes_page', 1);
        $paginaVisaoCategoriasSol = $request->input('visaoCategoriasSol_page', 1);

        // Visão Soluções
        if ($query && $abaAtiva === 'visaoSolucoes') {
            $solucoes = $this->buscarSolucoesComQuery($query, $pages['visaoSolucoes'], $abaAtiva);
            $categorias = $this->paginaVazia(10, $pages['visaoCategoriasSol']);
        } else {
            $solucoes = $this->buscarSolucoesComQuery(null, $pages['visaoSolucoes'], $abaAtiva);
            $categorias = $this->buscarCategoriaSolucao($query, $pages['visaoCategoriasSol'], $abaAtiva, 'visaoCategoriasSol_page');
        }

        // Minhas Soluções
        if ($query && $abaAtiva === 'mySolucoes') {
            $mySolucoes = $this->buscarMinhasSolucoes($query, $pages['mySolucoes'], $abaAtiva);
        } else {
            $mySolucoes = $this->buscarMinhasSolucoes(null, $pages['mySolucoes'], $abaAtiva);
        }

        // Gerenciar Soluções
        if($query && $abaAtiva == 'allSolucoes'){
            $allSolucoes = $this->buscarMinhasSolucoes($query, $pages['allSolucoes'], $abaAtiva);
        } else{
            $allSolucoes = $this->buscarMinhasSolucoes(null, $pages['allSolucoes'], $abaAtiva);
        }

        // Categorias
        if($query && $abaAtiva == 'categoriasSolucoes'){
            $categoriasSolucoes = $this->buscarCategoriaSolucao($query, $pages['categoriasSolucoes'], $abaAtiva, 'categoriasSolucoes_page');
        }else{
            $categoriasSolucoes = $this->buscarCategoriaSolucao(null, $pages['categoriasSolucoes'], $abaAtiva, 'categoriasSolucoes_page');
        }

        
        return view('solucoes.index', compact('categorias', 'solucoes', 'mySolucoes', 'allSolucoes', 'abaAtiva', 'query', 'categoriasSolucoes'));
        
    }

    public function buscarSolucoesComQuery($query, $pagina, $abaAtiva)
    {
        $resultado = Solucao::ativos();

        if (!empty($query)) {
            $resultado->where(function ($q) use ($query) {
                $q->where('titulo', 'like', '%' . $query . '%')
                    ->orWhere('descricao', 'like', '%' . $query . '%');
            });
        }

        return $resultado->latest()
            ->paginate(10, ['*'], 'solucoes_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarCategoriaSolucao($query, $pagina, $abaAtiva, $nomePagina)
    {
        $resultado = CategoriaSolucao::ativos();

        if($abaAtiva == 'visaoSolucoes'){
            $resultado->whereHas('solucoes', function ($q) {
                $q->ativos();
            });
        }
        if($abaAtiva == 'categoriasSolucoes'){
            $resultado->where('nomeCategoria', 'like', '%' . $query . '%');
        }
            $resultado->with(['solucoes' => function ($q) {
                $q->where('status', 'ativo')
                    ->latest()
                    ->take(2)
                    ->with(['user.nai', 'publicosAlvo']);  // eager load
            }]);

        return $resultado->paginate(5, ['*'], $nomePagina, $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarMinhasSolucoes($query, $pagina, $abaAtiva)
    {
        $resultado = Solucao::ativos()
        ->where('idUsuario', Auth::user()->id);

        if(!empty($query)){
            $resultado->where('titulo', 'like', '%' . $query . '%');
        }

        return $resultado->paginate(10, ['*'], 'mySolucoes_page', $pagina)
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
        $categorias = CategoriaSolucao::where('status', 'ativo')->get();
        $publicosAlvo = PublicoAlvo::where('status', 'ativo')->get();
        return view('solucoes.form', compact('categorias', 'publicosAlvo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'passosImplementacao' => 'required|string',
            'publicos_alvo' => 'required|array',
            'publicos_alvo.*' => 'integer|exists:publicos_alvo,id',
            'idCategoria' => 'required|integer',
            'arquivo' => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);

        if ($request->hasFile('arquivo')) {
            $caminho = $request->file('arquivo')->store('documentos', 'public');
        } else {
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

    public function show($id)
    {
        $solucao = Solucao::findOrFail($id);
        return view('solucoes.show', compact('solucao'));
    }

    public function edit($id)
    {
        $solucao = Solucao::findOrFail($id);
        $publicosAlvo = PublicoAlvo::where('status', 'ativo')->get();
        $categorias = CategoriaSolucao::where('status', 'ativo')->get();
        return view('solucoes.form', compact('solucao', 'publicosAlvo', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $solucao =  Solucao::findOrFail($id);

        if ($request->hasFile('arquivo')) {
            $caminho = $request->file('arquivo')->store('documentos', 'public');
        } else {
            $caminho = $solucao->arquivo;
        }

        $solucao->update([
            'titulo' => $request->input('titulo'),
            'descricao' => $request->input('descricao'),
            'passosImplementacao' => $request->input('passosImplementacao'),
            'arquivo' => $caminho,
            'idCategoria' => $request->input('idCategoria'),
            'idUsuario' => Auth::user()->id
        ]);        

        $solucao->publicosAlvo()->sync($request->publicos_alvo);
        return redirect()->route('solucoes.index')->with('success', 'Solução atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $solucao = Solucao::findOrFail($id);
        $solucao->status = 'inativo';
        $solucao->save();

        return redirect()->route('solucoes.index')->with('success', 'Solução excluída com sucesso!');
    }

    public function solucoesCategorias($idCategoria)
    {
        $categoria = CategoriaSolucao::findOrFail($idCategoria);
        $solucoes = $categoria->solucoes()->where('status', 'ativo')->get();
        return view('solucoes.solucoesCategorias', compact('solucoes', 'categoria'));
    }
}
