<?php

namespace App\Http\Controllers;

use App\Models\SugestaoTopico;
use Illuminate\Http\Request;
use App\Models\Topico;
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

    public function index(){
        $topicos = Topico::withCount('postagens')->where('status', 'ativo')->get();
        $topicosSugeridos = SugestaoTopico::all();
        $meusTopicos = $this->myTopicos();
        $minhasPostagens = $this->postagemController->myPostagens();
        return view('topicos.index', compact('topicos', 'meusTopicos', 'topicosSugeridos', 'minhasPostagens'));
    }

    public function create(){
        return view('topicos.form');
    }

    public function store(Request $request){
        $topico = new Topico;
        $topico->titulo = $request->titulo;
        $topico->idUsuario = Auth::user()->id;

        $topico->save();

        return redirect()->route('topicos.index')->with('success', 'Tópico criado com sucesso!');
    }

    public function myTopicos(){
        $idUsuario = Auth::user()->id;
        $meusTopicos = Topico::where('idUsuario', $idUsuario)->where('status', 'ativo')->get();
        return $meusTopicos;
    }

    public function edit($id){
        $topico = Topico::findOrFail($id);
        return response()->json($topico);
    }

    public function update(Request $request, $id){
        $topico = Topico::findOrFail($id);
        $topico->update($request->only(['titulo']));
        return redirect()->route('topicos.index')->with('success', 'Topico atualizado com sucesso!');
    }

    public function destroy(Request $request){
        $topico = Topico::findOrFail($request->id);
        $topico->update(['status' => 'inativo']);
        return redirect()->route('topicos.index')->with('success', 'Topico excluído com sucesso!');
    }

}
