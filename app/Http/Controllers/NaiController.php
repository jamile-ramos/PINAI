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
        return view('usuarios.formNai', $nai);
    }

    public function store(Request $request){
        $request->validate([
            'nome' => 'required|string|max:255',
            'instituicao' => 'required|string|max:255',
            'siglaInstituicao' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'cidade' => 'required|string|255',
            'email' => 'required|string|255',
            'telefone' => 'required|string|255',
            'site' => 'string|255'
        ]);

        $nai = Nai::create([
            'nome' => $request->nome,
            'instituicao' => $request->instituicao,
            'siglaInstituicao' => $request->siglaInstituicao,
            'estado' => $request->estado,
            'cidade' => $request->cidade,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'site' => $request->site
        ]);

        return view('painel.usuarios')->with('success', 'NAI cadastrado com sucesso!');
    }

    public function update(Request $request){
        
    }
}
