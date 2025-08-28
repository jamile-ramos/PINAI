<?php

namespace App\Http\Controllers;

use App\Events\NaiCriado;
use Illuminate\Http\Request;
use App\Models\Nai;
use App\Models\User;
use App\Notifications\NaiCriadoNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class NaiController extends Controller
{

    public function create()
    {
        return view('usuarios.formNai');
    }

    public function edit($id)
    {
        $nai = Nai::findOrFail($id);
        return view('usuarios.formNai', compact('nai'));
    }

    public function show($id)
    {
        $nai = Nai::findOrFail($id);
        return view('usuarios.showNai', compact('nai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'siglaNai' => 'required|string|max:50',
            'instituicao' => 'required|string|max:255',
            'siglaInstituicao' => 'required|string|max:50',
            'estado' => 'required|string|max:2',
            'cidade' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/'
            ],
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

        // Notificacao via email
        event(new NaiCriado($nai));

        // Notificação do site
        $destinatarios = User::where('tipoUsuario', 'admin')
            ->where('id', '!=', Auth::id())
            ->get();
        Notification::send($destinatarios, new NaiCriadoNotification($nai));

        return redirect()->route('painel.usuarios')->with('success', 'NAI cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
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

    public function destroy($id)
    {
        $nai = Nai::findOrFail($id);
        $nai->status = 'inativo';
        $nai->save();

        return redirect()->route('painel.usuarios')->with('success', 'NAI excluído com sucesso!');
    }
}
