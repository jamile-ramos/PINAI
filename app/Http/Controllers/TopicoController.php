<?php

namespace App\Http\Controllers;

use App\Models\SugestaoTopico;
use Illuminate\Http\Request;
use App\Models\Topico;
use App\Models\Postagem;
use App\Models\TopicoUser;
use Illuminate\Support\Facades\Auth;

class TopicoController extends Controller
{
    // Injeção de Dependência
    protected $postagemController;

    public function __construct(PostagemController $postagemController)
    {
        $this->postagemController = $postagemController;
    }

    public function index(Request $request)
    {
        $query = $request->input('query');
        $abaAtiva = $request->input('abaAtiva');

        $pages = [
            'visaoTopicos' => $request->input('topicos_page', 1),
            'myTopicos' => $request->input('myTopicos_page', 1),
            'allTopicos' => $request->input('allTopicos_page', 1),
            'sugestoesTopicos' => $request->input('sugestoes_page', 1),
        ];

        // Visão Topicos
        if ($query && $abaAtiva === 'visaoTopicos') {
            $topicos = $this->buscarTopicosComQuery($query, $abaAtiva, $pages['visaoTopicos']);
        } else {
            $topicos = $this->buscarTopicosComQuery(null, $abaAtiva, $pages['visaoTopicos']);
        }

        // Meus Tópicos
        if ($query && $abaAtiva === 'myTopicos') {
            $meusTopicos = $this->buscarMeusTopicos($query, $pages['myTopicos'], $abaAtiva);
        } else {
            $meusTopicos = $this->buscarMeusTopicos(null, $pages['myTopicos'], $abaAtiva);
        }

        // Gerenciar Tópicos
        if ($query && $abaAtiva === 'allTopicos') {
            $allTopicos = $this->buscarTodosTopicos($query, $pages['allTopicos'], $abaAtiva);
        } else {
            $allTopicos = $this->buscarTodosTopicos(null, $pages['allTopicos'], $abaAtiva);
        }

        // Tópicos Sugeridos
        if ($query && $abaAtiva === 'sugestoes') {
            $topicosSugeridos = $this->buscarTopicosSugeridos($query, $pages['sugestoesTopicos'], $abaAtiva);
        } else {
            $topicosSugeridos = $this->buscarTopicosSugeridos(null, $pages['sugestoesTopicos'], $abaAtiva);
        }
        return view('topicos.index', compact('topicos', 'allTopicos', 'meusTopicos', 'topicosSugeridos', 'abaAtiva', 'query'));
    }

    public function buscarTopicosComQuery($query, $abaAtiva, $pagina)
    {
        $resultados = Topico::ativos()
            // ordena Topicos pela data da postagem mais recente
            ->orderByDesc(
                Postagem::select('updated_at')
                    ->whereColumn('idTopico', 'topicos.id')
                    ->orderByDesc('updated_at')
                    ->limit(1)
            );

        if (!empty($query)) {
            $resultados->where('titulo', 'like', '%' . $query . '%');
        }
        // Eager load da postagem mais recente (limit 1)
        return $resultados->with(['postagens' => function ($q) {
            $q->orderBy('updated_at', 'desc')->limit(1);
        }])
            ->paginate(10, ['*'], 'topicos_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarMeusTopicos($query, $pagina, $abaAtiva)
    {
        $resultados = Topico::ativos();

        if (!empty($query)) {
            $resultados->where('titulo', 'like', '%' . $query . '%');
        }
        // ordena Topicos pela data criacão
        return $resultados->orderByDesc('created_at')
            ->paginate(10, ['*'], 'myTopicos_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarTodosTopicos($query, $pagina, $abaAtiva){
        $resultados = Topico::ativos();

        if(!empty($query)){
            $resultados->where(function ($q) use ($query) {
                $q->where('titulo', 'like', '%' . $query . '%')
                    ->orWhereHas('user', function ($sub) use ($query) {
                        $sub->where('name', 'like', '%' . $query . '%');
                    });
            });
        }
                
        // ordena Topicos pela data criacão
        return $resultados->orderByDesc('created_at')
                ->paginate(10, ['*'], 'allTopicos_page', $pagina)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarTopicosSugeridos($query, $pagina, $abaAtiva){
        $resultados = SugestaoTopico::ativos();
        
        if(!empty($query)){
            $resultados->where('titulo', 'like', '%' . $query . '%');
        }
                
                // ordena Topicos pela data criacão
                return $resultados->orderByDesc('created_at')
                ->paginate(10, ['*'], 'sugestoes_page', $pagina)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function create()
    {
        return view('topicos.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255'
        ]);

        $topico = new Topico;
        $topico->titulo = $request->titulo;
        $topico->idUsuario = Auth::user()->id;

        $topico->save();

        return redirect()->route('topicos.index')->with('success', 'Tópico criado com sucesso!');
    }

    public function edit($id)
    {
        $topico = Topico::findOrFail($id);
        return response()->json($topico);
    }

    public function update(Request $request, $id)
    {
        $topico = Topico::findOrFail($id);
        $topico->update($request->only(['titulo']));
        return redirect()->route('topicos.index')->with('success', 'Topico atualizado com sucesso!');
    }

    public function destroy(Request $request)
    {
        $topico = Topico::findOrFail($request->id);
        $topico->update(['status' => 'inativo']);
        return redirect()->route('topicos.index')->with('success', 'Topico excluído com sucesso!');
    }
}
