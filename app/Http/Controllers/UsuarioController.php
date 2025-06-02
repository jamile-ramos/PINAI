<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Nai;

class UsuarioController extends Controller
{

    public function index()
    {

        $query = request('query');

        if($query){
            $usuarios = User::where([ 
                ['name', 'like', '%'.$query.'%']
            ])->get();
        } else{
            $usuarios = User::all();
        }

        $nais = Nai::where('status', 'ativo')->get();
        return view('usuarios.painelUsuarios', compact('usuarios','query', 'nais'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->userName,
            'email' => $request->userEmail,
            'tipoUsuario' => $request->tipoUsuario,
            'idNai' => $request->userNai
        ]);

        return redirect('/painelUsuarios')->with('success', 'Dados do usuário atualizado com sucesso!');
    }

    public function updateStatus(Request $request, $id)
    {
        //dd($request->all());
        if($request->status == 'ativo'){
            $status = 'inativo';
        }else{
            $status = 'ativo';
        }

        $user = User::findOrFail($id);

        $user->update(['status' => $status]);

        return redirect('/painelUsuarios')->with('success', 'Status atualizado com sucesso!');
    }
}
