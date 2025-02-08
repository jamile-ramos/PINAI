<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use \App\Models\SugestaoTopico;
use Illuminate\Support\Facades\Auth;

class SugestaoTopicoController extends Controller
{
    public function store(Request $request){
        $topico = new SugestaoTopico;
        $topico->titulo = $request->titulo;
        $topico->idUsuario = Auth::user()->id;

        $topico->save();
        return redirect()->route('topicos.index')->with('success', 'Tópico sugerido com sucesso!');
    }

    public function updateStatus(Request $request, $id){
        $status = $request->input('status');

        $sugestao = SugestaoTopico::findOrFail($id);

        $sugestao->update(['status' => $status]);

        return redirect()->route('topicos.index')->with('success', 'Status da sugestão atualizado com sucesso!');
    }

    public function delete(Request $request){
        $id = $request->id;

        SugestaoTopico::destroy($id);

        return redirect()->route('topicos.index')->with('success', 'Sugestão excluída com sucesso!');

    }
    
}
