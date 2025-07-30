<?php

namespace App\Http\Controllers;

use App\Models\PublicoAlvo;
use Illuminate\Http\Request;

class PublicoAlvoController extends Controller
{
    public function index(Request $request){
        
    }

    public function store(Request $request){
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string'
        ]);

        $publicoAlvo = PublicoAlvo::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return redirect(url()->previous())->with('success', 'Público Alvo criado com sucesso!');
    }

    public function destroy(Request $request){
        $publico = PublicoAlvo::findOrFail($request->id);
        $publico->status = 'inativo';
        $publico->save();
        return redirect()->back()->with('success', 'Público-alvo excluído com sucesso!');
    }
}
