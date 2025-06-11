<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nai;

class NaiController extends Controller
{
    
    public function create(){
        return view('usuarios.formNai');
    }

    public function edit($id){
        $nai = Nai::findOrFail($id);
        return view('usuarios.formNai', compact('nai'));
    }

    public function show($id){
        $nai = Nai::findOrFail($id);
        return view('usuarios.showNai', compact('nai'));
    }

    public function store(Request $request){
        $request->validate([
            'nome' => 'required|string|max:255',
            'siglaNai' => 'required|string|max:50',
            'instituicao' => 'required|string|max:255',
            'siglaInstituicao' => 'required|string|max:50',
            'estado' => 'required|string|max:2',
            'cidade' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:255',
            'site' => 'nullable|string|max:255'
        ]);

        $nai = Nai::create([
            'nome' => $request->nome,
            'siglaNai' => $request->siglaNai,
            'instituicao' => $request->instituicao,
            'siglaInstituicao' => $request->siglaInstituicao,
            'estado' => $request->estado,
            'cidade' => $request->cidade,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'site' => $request->site
        ]);

        return redirect()->route('painel.usuarios')->with('success', 'NAI cadastrado com sucesso!');
    }

    public function update(Request $request, $id){
        $nai = Nai::findOrFail($id);
        $nai->update([
            'nome' => $request->nome,
            'siglaNai' => $request->siglaNai,
            'instituicao' => $request->instituicao,
            'siglaInstituicao' => $request->siglaInstituicao,
            'estado' => $request->estado,
            'cidade' => $request->cidade,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'site' => $request->site
        ]);

        return redirect()->route('painel.usuarios')->with('success', 'Informações do NAI atualizadas com sucesso!');

    }

    public function destroy(Request $request){
        $nai = Nai::findOrFail($request->id);
        $nai->status = 'inativo';
        $nai->save();

        return redirect()->route('painel.usuarios')->with('success', 'NAI excluído com sucesso!');
    }
}
