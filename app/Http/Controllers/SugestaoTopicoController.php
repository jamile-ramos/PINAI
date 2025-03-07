<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use \App\Models\SugestaoTopico, App\Models\Topico;
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

    public function updateStatusSituacao(Request $request, $id){
        $status_situacao = $request->input('status');
        
        $sugestao = SugestaoTopico::findOrFail($id);
        
        $topico = new Topico;
        if($status_situacao == 'aprovado'){
            $topico->titulo = $sugestao->titulo;
            $topico->idUsuario = $sugestao->idUsuario;

            $topico->save();
        }else{
            $topico = Topico::where('titulo', $sugestao->titulo)->where('idUsuario', $sugestao->idUsuario)->first();
            if($topico){
                $topico->status = 'inativo';
                $topico->save();
            }
        }
        dd($status_situacao);

        $sugestao->update(['status_situacao' => $status_situacao]);

        return redirect()->route('topicos.index')->with('success', 'Status da sugestão atualizado com sucesso!');
    }

    public function destroy(Request $request){
        $id = $request->id;

        $sugestao = SugestaoTopico::findOrFail($id);

        if($sugestao->status_situacao == 'aprovado'){
            $topico = Topico::where('titulo', $sugestao->titulo)->where('idUsuario', $sugestao->idUsuario)->first();
        
            if($topico){
                $topico->update(['status' => 'inativo']);
            }
        }

        $sugestao->update(['status' => 'inativo']);

        return redirect()->route('topicos.index')->with('success', 'Sugestão excluída com sucesso!');

    }
    
}
