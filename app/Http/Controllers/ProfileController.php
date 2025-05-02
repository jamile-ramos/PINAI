<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Postagem;
use App\Models\Documento;
use App\Models\Solucao;
use App\Models\Noticia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $minhasNoticias = Noticia::join('categorias_noticias', 'noticias.idCategoria', '=', 'categorias_noticias.id')
        ->where('noticias.status', 'ativo')
        ->where('noticias.idUsuario', Auth::user()->id)
        ->orderBy('noticias.titulo', 'asc')
        ->select('noticias.*')
        ->get();
        $minhasPostagens = Postagem::join('topicos', 'postagens.idTopico', '=', 'topicos.id')
            ->where('postagens.status', 'ativo')
            ->where('postagens.idUsuario', Auth::user()->id)
            ->orderBy('topicos.titulo', 'asc')
            ->select('postagens.*')
            ->get();
        $meusDocumentos = Documento::join('categorias_documentos', 'documentos.idCategoria', '=', 'categorias_documentos.id')
        ->where('documentos.status', 'ativo')
        ->where('documentos.idUsuario', Auth::user()->id)
        ->orderBy('documentos.nomeArquivo', 'asc')
        ->select('documentos.*')
        ->get();
        $minhasSolucoes = Solucao::join('categorias_solucoes', 'solucoes.idCategoria', '=', 'categorias_solucoes.id')
        ->where('solucoes.status', 'ativo')
        ->where('solucoes.idUsuario', Auth::user()->id)
        ->orderBy('solucoes.titulo', 'asc')
        ->select('solucoes.*')
        ->get();
        return view('profile.myProfile', [
            'user' => $request->user(),
            'myPostagens' => $minhasPostagens,
            'myDocumentos' => $meusDocumentos,
            'mySolucoes' => $minhasSolucoes,
            'myNoticias' => $minhasNoticias
        ]);
    }


    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->update(['status'=> 'inativo']);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
