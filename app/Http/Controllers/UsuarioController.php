<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Nai;
use Laravel\Pail\ValueObjects\Origin\Console;

class UsuarioController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');
        $abaAtiva = $request->input('abaAtiva');

        $paginaUsuarios = $request->input('users_page', 1);
        $paginaNais = $request->input('nais_page', 1);


        if($query && $abaAtiva === 'all-users'){
            $usuarios = User::with('nai')
            ->where(function($q) use ($query){
                $q->where('name', 'like', $query . '%')
                ->orWhere('email', 'like', $query . '%');
            })
            ->orWhereHas('nai', function($q) use ($query){
                $q->where('siglaNai', 'like', $query . '%');
            })
            ->paginate(10, ['*'], 'users_page', $paginaUsuarios)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else{
            $usuarios = User::with('nai')->paginate(10, ['*'], 'users_page', $paginaUsuarios);
        }

        if($query && $abaAtiva === 'all-nais'){
            $nais = Nai::where('status', 'ativo')
            ->where(function($q) use ($query){
                $q->where('nome', 'like', $query . '%')
                ->orwhere('instituicao', 'like', $query . '%')
                ->orwhere('siglaNai', 'like', $query . '%');
            })
            ->paginate(10, ['*'], 'nais_page', $paginaNais)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
        } else{
            $nais = Nai::where('status', 'ativo')->paginate(10, ['*'], 'nais_page', $paginaNais);
        }

        return view('usuarios.painelUsuarios', compact('usuarios','query', 'nais', 'abaAtiva'));
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
