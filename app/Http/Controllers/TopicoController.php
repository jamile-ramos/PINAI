<?php

namespace App\Http\Controllers;

use App\Models\SugestaoTopico;
use Illuminate\Http\Request;
use App\Models\Topico;
use App\Models\TopicoUser;
use Illuminate\Support\Facades\Auth;

class TopicoController extends Controller
{
    public function index(){
        $topicos = Topico::all();
        $topicosSugeridos = SugestaoTopico::all();
        $meusTopicos = $this->myTopicos();
        return view('topicos.index', compact('topicos', 'meusTopicos', 'topicosSugeridos'));
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
        $meusTopicos = Topico::where('idUsuario', $idUsuario)->get();
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

    public function delete(Request $request){
        $id = $request->id;
        Topico::destroy($id);
        return redirect()->route('topicos.index')->with('success', 'Topico excluído com sucesso!');
    }
}
