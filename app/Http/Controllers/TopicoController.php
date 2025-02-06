<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topico;
use Illuminate\Support\Facades\Auth;

class TopicoController extends Controller
{
    public function index(){
        $topicos = Topico::all();
        return view('topicos.index', compact('topicos'));
    }

    public function create(){
        return view('topicos.form');
    }

    public function store(Request $request){
        $topico = new Topico;
        $topico->titulo = $request->titulo;
        $topico->idUsuario = Auth::user()->id;

        $topico->save();

        return redirect()->route('topicos.index')->with('success', 'Tópico criado com sucesso!');
    }
}
