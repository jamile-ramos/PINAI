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
            'mySolucoes' => $request->input('mySolucoes_page', 1)
        ];

        $paginaVisaoSolucoes = $request->input('solucoes_page', 1);
        $paginaVisaoCategoriasSol = $request->input('visaoCategoriasSol_page', 1);

        // Visão Soluções
        if ($query && $abaAtiva === 'visaoSolucoes') {
            $solucoes = $this->buscarSolucoesComQuery($query, $pages['visaoSolucoes'], $abaAtiva);
            $categorias = $this->paginaVazia(10, $pages['visaoCategoriasSol']);
        } else {
            $categorias = $this->buscarCategoriaSolucao($query, $pages['visaoCategoriasSol'], $abaAtiva);
            $solucoes = $this->paginaVazia(10, $pages['visaoSolucoes']);
        }

        // Minhas Soluções
        if ($query && $abaAtiva === 'mySolucoes') {
            $mySolucoes = $this->buscarMinhasSolucoes($query, $pages['mySolucoes'], $abaAtiva);
        } else {
            //$mySolucoes = $this->buscarMinhasSolucoes(10, $pages['visaoSolucoes']);
        }



        $mySolucoes = Solucao::where('status', 'ativo')->where('idUsuario', Auth::user()->id)->get();
        return view('solucoes.index', compact('categorias', 'solucoes', 'mySolucoes', 'abaAtiva', 'query'));
    }

    public function buscarSolucoesComQuery($query, $pagina, $abaAtiva)
    {
        $resultados = Solucao::ativos();

        if (!empty($query)) {
            $resultados->where(function ($q) use ($query) {
                $q->where('titulo', 'like', '%' . $query . '%')
                    ->orWhere('descricao', 'like', '%' . $query . '%');
            });
        }

        return $resultados->latest()
            ->paginate(10, ['*'], 'solucoes_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarCategoriaSolucao($query, $pagina, $abaAtiva)
    {
        $resultados = CategoriaSolucao::ativos();

        $resultados->whereHas('solucoes', function ($q) {
            $q->ativos();
        })
            ->with(['solucoes' => function ($q) {
                $q->where('status', 'ativo')
                    ->latest()
                    ->take(2)
                    ->with(['user.nai', 'publicosAlvo']);  // eager load
            }]);

        return $resultados->paginate(5, ['*'], 'visaoCategoriasSol_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarMinhasSolucoes($query, $pagina, $abaAtiva)
    {
        $resultados = Solucao::ativos();

        $resultados->whereHas('solucoes', function ($q) {
            $q->ativos()
                ->where('idUsuario', Auth::user()->id);
        });

        if(!empty($query)){
            $resultados->where('titulo', 'like', '%' . $query . '%');
        }

        return $resultados->paginate(10, ['*'], 'mySolucoes', $pagina)
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

    public function destroy(Request $request)
    {
        $solucao = Solucao::findOrFail($request->id);
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
