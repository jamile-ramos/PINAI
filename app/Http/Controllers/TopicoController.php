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

    public function index()
    {
        $topicos = Topico::withCount('postagens')
            ->with(['postagens' => function ($query) {
                $query->orderBy('updated_at', 'desc')->take(1);
            }])->where('status', 'ativo')
            ->orderBy(Postagem::select('updated_at')->whereColumn('idTopico', 'topicos.id')
                ->latest()->limit(1), 'desc')->get();
        $topicosSugeridos = SugestaoTopico::where('status', 'ativo')->get();
        $meusTopicos = $this->myTopicos();
        return view('topicos.index', compact('topicos', 'meusTopicos', 'topicosSugeridos'));
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

    public function myTopicos()
    {
        $idUsuario = Auth::user()->id;
        $meusTopicos = Topico::where('idUsuario', $idUsuario)->where('status', 'ativo')->get();
        return $meusTopicos;
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
