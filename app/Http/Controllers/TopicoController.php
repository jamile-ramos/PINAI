<?php

namespace App\Http\Controllers;

use App\Events\TopicoCriado;
use App\Http\Controllers\Concerns\EnforcesCorrectSlug;
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
        ->withCount('postagens')
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
        $resultados = Topico::ativos()
        ->where('idUsuario', Auth::user()->id);

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

        event(new TopicoCriado($topico));

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

    public function destroy($id)
    {
        $topico = Topico::findOrFail($id);
        $topico->update(['status' => 'inativo']);
        return redirect()->route('topicos.index')->with('success', 'Topico excluído com sucesso!');
    }

    use EnforcesCorrectSlug;

    public function show($idTopico, $slug, Request $request)
    {

        $topico = Topico::findOrFail($idTopico);

        $redirect = $this->redirectIfWrongSlug($topico, $request->route('slug'), 'postagens.index');

        if ($redirect) {
            return $redirect;
        }

        $abaAtiva = $request->input('abaAtiva');
        $query = $request->input('query');

        $pages = [
            'visaoPostagens' => (int) $request->input('postagens_page', 1),
            'myPostagens' => (int) $request->input('myPostagens_page', 1),
            'allPostagens' => (int) $request->input('allPostagens_page', 1),
        ];

        // Visao Postagens
        if ($query && $abaAtiva === 'visaoPostagens') {
            $postagens = $this->buscarPostagensComQuery($idTopico, $query, $abaAtiva, $pages['visaoPostagens']);
        } else {
            $postagens = $this->buscarPostagensComQuery($idTopico, null, $abaAtiva, $pages['visaoPostagens']);
        }

        // Minhas Postagens
        if ($query && $abaAtiva === 'myPostagens') {
            $minhasPostagens = $this->buscarMinhasPostagens($idTopico, $query, $pages['myPostagens'], $abaAtiva);
        } else {
            $minhasPostagens = $this->buscarMinhasPostagens($idTopico, null, $pages['myPostagens'], $abaAtiva);
        }

        // Gerenciar Postagens
        if ($query && $abaAtiva === 'allPostagens') {
            $allPostagens = $this->buscarTodasPostagens($idTopico, $query, $pages['allPostagens'], $abaAtiva);
        } else {
            $allPostagens = $this->buscarTodasPostagens($idTopico, null, $pages['allPostagens'], $abaAtiva);
        }

        $topico = Topico::findOrFail($idTopico);
        return view('postagens.index', compact('postagens', 'allPostagens', 'minhasPostagens', 'topico', 'abaAtiva', 'query'));
    }

    public function buscarPostagensComQuery($idTopico, $query, $abaAtiva, $pagina)
    {

        $resultado = Postagem::ativos()
            ->where('idTopico', $idTopico)
            ->whereHas('topico', function ($q) {
                $q->ativos();
            });

        if (!empty($query)) {
            $resultado->where('titulo', 'like', '%' . $query . '%');
        }

        return $resultado->withCount('respostas')
            ->orderByDesc('updated_at')
            ->paginate(10, ['*'], 'postagens_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarMinhasPostagens($idTopico, $query, $pagina, $abaAtiva)
    {

        $resultado = Postagem::ativos()
            ->where('idTopico', $idTopico)
            ->where('idUsuario', Auth::user()->id)
            ->whereHas('topico', function ($q) {
                $q->ativos();
            });

        if (!empty($query)) {
            $resultado->where('titulo', 'like', '%' . $query . '%');
        }

        return $resultado->orderByDesc('created_at')
            ->paginate(10, ['*'], 'myPostagens_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    public function buscarTodasPostagens($idTopico, $query, $pagina, $abaAtiva)
    {
        $resultado = Postagem::ativos()
            ->where('idTopico', $idTopico)
            ->whereHas('topico', function ($q) {
                $q->ativos();
            });

        if (!empty($query)) {
            $resultado->where(function ($q) use ($query) {
                $q->where('titulo', 'like', '%' . $query . '%')
                    ->orWhereHas('user', function ($sub) use ($query) {
                        $sub->where('name', 'like', '%' . $query . '%');
                    });
            });
        }

        return $resultado->paginate(10, ['*'], 'allPostagens_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }
}
