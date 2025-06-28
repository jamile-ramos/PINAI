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

        $paginaVisaoTopicos = $request->input('topicos_page', 1);
        $paginaMyTopicos = $request->input('myTopicos_page', 1);
        $paginaAllTopicos = $request->input('allTopicos_page', 1);
        $paginaSugestoesTopicos = $request->input('sugestoes_page', 1);

        // Visão Topicos
        if($query && $abaAtiva === 'visaoTopicos'){
            $topicos = Topico::where('status', 'ativo')
            ->where('titulo', 'like', '%' . $query . '%')
            // ordena Topicos pela data da postagem mais recente
            ->orderByDesc(
                Postagem::select('updated_at')
                    ->whereColumn('idTopico', 'topicos.id')
                    ->orderByDesc('updated_at')
                    ->limit(1)
            )
            // Eager load da postagem mais recente (limit 1)
            ->with(['postagens' => function ($q) {
                $q->orderBy('updated_at', 'desc')->limit(1);
            }])
            ->paginate(10, ['*'], 'topicos_page', $paginaVisaoTopicos)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
            
        }else{
            $topicos = Topico::withCount('postagens')
            ->with(['postagens' => function ($query) {
                $query->orderBy('updated_at', 'desc')->take(1);
            }])->where('status', 'ativo')
            ->orderBy(Postagem::select('updated_at')->whereColumn('idTopico', 'topicos.id')
                ->latest()->limit(1), 'desc')
                ->paginate(10, ['*'], 'topicos_page', $paginaVisaoTopicos)
                ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }

        // Meus Tópicos
        if ($query && $abaAtiva === 'myTopicos') {
            $meusTopicos = Topico::where('status', 'ativo')
            ->where('titulo', 'like', '%' . $query . '%')
            // ordena Topicos pela data criacão
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'myTopicos_page', $paginaMyTopicos)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else {
            $meusTopicos = Topico::where('status', 'ativo')
            ->where('idUsuario', Auth::user()->id)
            // ordena Topicos pela data criacão
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'myTopicos_page', $paginaMyTopicos)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }

        // Gerenciar Tópicos
        if ($query && $abaAtiva === 'allTopicos') {
            $allTopicos = Topico::where('status', 'ativo')
            ->where(function($q) use ($query){
                $q->where('titulo', 'like', '%' . $query . '%')
                ->orWhereHas('user', function($sub) use($query){
                    $sub->where('name', 'like', '%' . $query . '%');
                });
            })
            // ordena Topicos pela data criacão
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'allTopicos_page', $paginaAllTopicos)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else {
            $allTopicos = Topico::where('status', 'ativo')
            // ordena Topicos pela data criacão
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'allTopicos_page', $paginaAllTopicos)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }

        // Tópicos Sugeridos
        if ($query && $abaAtiva === 'sugestoes') {
            $topicosSugeridos = SugestaoTopico::where('status', 'ativo')
            ->where('titulo', 'like', '%' . $query . '%')
            // ordena Topicos pela data criacão
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'sugestoes_page', $paginaSugestoesTopicos)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else {
            $topicosSugeridos = SugestaoTopico::where('status', 'ativo')
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'sugestoes_page', $paginaSugestoesTopicos)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        }
        return view('topicos.index', compact('topicos','allTopicos', 'meusTopicos', 'topicosSugeridos', 'abaAtiva', 'query'));
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
