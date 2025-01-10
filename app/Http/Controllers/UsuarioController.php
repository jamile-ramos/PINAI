<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Validated;

class UsuarioController extends Controller
{

    public function index(Request $request){

        $usuarios = User::all();

        return view('usuarios.painelUsuarios', compact('usuarios'));
    }

    public function update(Request $request, $id){
        
    }
}
