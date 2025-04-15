<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\SugestaoTopico, App\Models\Topico;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class SugestaoTopicoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255'
        ]);

        $topico = new SugestaoTopico;
        $topico->titulo = $request->titulo;
        $topico->idUsuario = Auth::user()->id;

        $topico->save();
        return redirect()->route('topicos.index')->with('success', 'Tópico sugerido com sucesso!');
    }

    public function updateStatusSituacao(Request $request, $id)
    {
        $status_situacao = $request->input('status');

        $sugestao = SugestaoTopico::findOrFail($id);

        $topico = Topico::where('titulo', $sugestao->titulo)
            ->where('idUsuario', $sugestao->idUsuario)
            ->first();
        if ($status_situacao == 'aprovado') {
            if (!$topico) {
                $topico = new Topico;
                $topico->titulo = $sugestao->titulo;
                $topico->idUsuario = $sugestao->idUsuario;
                $topico->status = 'ativo';
            }else if($topico->status == 'inativo'){
                $topico->status = 'ativo';
            }
            $topico->save();
        } else if ($status_situacao == 'pendente' || $status_situacao == 'reprovado') {
            if ($topico && $topico->status == 'ativo') {
                $topico->status = 'inativo';
                $topico->save();
            }
        }

        $sugestao->update(['status_situacao' => $status_situacao]);

        return redirect()->route('topicos.index')->with('success', 'Status da sugestão atualizado com sucesso!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        $sugestao = SugestaoTopico::findOrFail($id);

        if ($sugestao->status_situacao == 'aprovado') {
            $topico = Topico::where('titulo', $sugestao->titulo)->where('idUsuario', $sugestao->idUsuario)->first();

            if ($topico) {
                $topico->update(['status' => 'inativo']);
            }
        }

        $sugestao->update(['status' => 'inativo']);

        return redirect()->route('topicos.index')->with('success', 'Sugestão excluída com sucesso!');
    }
}
