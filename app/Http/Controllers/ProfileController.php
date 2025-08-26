<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Postagem;
use App\Models\Documento;
use App\Models\Solucao;
use App\Models\Noticia;
use App\Models\Topico;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->input('query');
        $abaAtiva = $request->input('abaAtiva');

        $pages = [
            'myNoticias' => $request->input('myNoticias_page', 1),
            'myPostagens' => $request->input('myPostagens_page', 1),
            'myDocumentos' => $request->input('myDocumentos_page', 1),
            'mySolucoes' => $request->input('mySolucoes_page', 1),
        ];

        if ($query && $abaAtiva === 'myNoticias') {
            $minhasNoticias = Noticia::buscarMinhasNoticias($query, $pages['myNoticias'], $abaAtiva, 5);
        } else {
            $minhasNoticias = Noticia::buscarMinhasNoticias(null, $pages['myNoticias'], $abaAtiva, 5);
        }

        if ($query && $abaAtiva === 'myDocumentos') {
            $meusDocumentos = Documento::buscarMeusDocumentos($query, $pages['myDocumentos'], $abaAtiva, 6);
        } else {
            $meusDocumentos = Documento::buscarMeusDocumentos(null, $pages['myDocumentos'], $abaAtiva, 6);
        }

        if ($query && $abaAtiva === 'mySolucoes') {
            $minhasSolucoes = Solucao::buscarMinhasSolucoes($query, $pages['mySolucoes'], $abaAtiva, 5);
        } else {
            $minhasSolucoes = Solucao::buscarMinhasSolucoes($query, $pages['mySolucoes'], $abaAtiva, 5);
        }


        if ($query && $abaAtiva === 'myPostagens') {
            $minhasPostagens = $this->minhasPostagensProfile($query, $abaAtiva, $pages['myPostagens']);
        } else {
            $minhasPostagens = $this->minhasPostagensProfile(null, $abaAtiva, $pages['myPostagens']);
        }

        return view('profile.myProfile', [
            'user' => $request->user(),
            'myPostagens' => $minhasPostagens,
            'myDocumentos' => $meusDocumentos,
            'mySolucoes' => $minhasSolucoes,
            'myNoticias' => $minhasNoticias,
            'abaAtiva' => $abaAtiva,
            'query' => $query
        ]);
    }

    public function minhasPostagensProfile($query, $abaAtiva, $pagina)
    {
        $resultado = Postagem::ativos()
            ->withCount('respostas')
            ->with('topico')
            ->where('idUsuario', Auth::id());

        if ($query) {
            $resultado->where('titulo', 'like', "%{$query}%");
        }

        return $resultado
            ->orderBy(
                Topico::select('titulo')
                    ->whereColumn('topicos.id', 'postagens.idTopico')
                    ->limit(1),
                'asc' 
            )
            ->paginate(5, ['*'], 'myPostagens_page', $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
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

        $user->update(['status' => 'inativo']);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
