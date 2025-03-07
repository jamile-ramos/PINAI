<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;

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
        return view('usuarios.painelUsuarios', compact('usuarios','query'));
    }

    public function update(Request $request, $id)
    {
        $tipoUsuario = $request->tipoUsuario;

        $post = User::findOrFail($id);

        $post->update(['tipoUsuario' => $tipoUsuario]);

        return redirect('/painelUsuarios')->with('success', 'Tipo de usuário alterado com sucesso!');
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
