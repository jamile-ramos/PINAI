<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\NaiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\PostagemController;
use App\Http\Controllers\PublicoAlvoController;
use App\Http\Controllers\RespostaController;
use App\Http\Controllers\SolucaoController;
use App\Http\Controllers\SugestaoTopicoController;
use App\Http\Controllers\TopicoController;
use App\Models\Comentario;
use App\Models\Noticia;
use App\Models\PublicoAlvo;
use App\Models\Solucao;

Route::middleware('guest')->get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $noticias = Noticia::latest()->where('status', 'ativo')->take(3)->get();
    return view('dashboard', compact('noticias'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/myProfile', [ProfileController::class, 'index'])->name('profile.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Painel de usuários
Route::middleware('auth')->group(function () {
    Route::controller(UsuarioController::class)->prefix('painelUsuarios')->name('painel.')->group(function () {
        Route::get('/', 'index')->name('usuarios');
        Route::put('/alterar/{id}', 'update')->name('update');
        Route::put('/status/{id}', 'updateStatus')->name('updateStatus');
    });

    // Nais
    Route::prefix('painelUsuarios/nais')->name('nais.')->controller(NaiController::class)->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::get('/show/{id}', 'show')->name('show');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });
    // Portal de Notícias
    Route::prefix('noticias')->name('noticias.')->controller(NoticiaController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/show/{id}', 'show')->name('show');
        Route::get('/categorias/{idCategoria}', 'noticiasCategorias')->name('noticiasCategorias');
    });

    // Categorias
    Route::prefix('categorias')->name('categorias.')->controller(CategoriaController::class)->group(function () {
        Route::get('/create/{tipo}', 'create')->name('create');
        Route::post('/store/{tipo}', 'store')->name('store');
        Route::delete('/destroy/{tipo}/{id}', 'destroy')->name('destroy');
    });

    // Fórum de Discussão (Tópicos)
    Route::prefix('topicos')->name('topicos.')->controller(TopicoController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
    });

    // Postagens
    Route::prefix('postagens')->name('postagens.')->controller(PostagemController::class)->group(function () {
        Route::get('/{idTopico}', 'index')->name('index');
        Route::get('/create/{idTopico}', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/show/{id}', 'show')->name('show');
    });

    // Respostas
    Route::prefix('respostas')->name('respostas.')->controller(RespostaController::class)->group(function () {
        Route::get('/create/{idPostagem}', 'create')->name('create');
        Route::post('/store/{idPostagem}', 'store')->name('store');
        Route::get('/edit/{idResposta}', 'edit')->name('edit');
        Route::put('/update/{idResposta}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    // Comentários
    Route::prefix('comentarios')->name('comentarios.')->controller(ComentarioController::class)->group(function () {
        Route::post('/store', 'store')->name('store');
        Route::get('/usuarios/{idResposta}', 'usuariosDaResposta')->name('usuarios');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    // Sugestões de Tópicos
    Route::prefix('sugestoes')->name('sugestoes.')->controller(SugestaoTopicoController::class)->group(function () {
        Route::post('/store', 'store')->name('store');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::put('/statusSituacao/{id}', 'updateStatusSituacao')->name('updateStatusSituacao');
    });

    // Documentos (Biblioteca Digital)
    Route::prefix('documentos')->name('documentos.')->controller(DocumentoController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/categorias/{idCategoria}', 'documentosCategorias')->name('documentosCategorias');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    // Soluções (Banco de Soluções)
    Route::prefix('solucoes')->name('solucoes.')->controller(SolucaoController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/show/{id}', 'show')->name('show');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/categorias/{idCategoria}', 'solucoesCategorias')->name('solucoesCategorias');
    });

    // Público-Alvo de Soluções
    Route::prefix('solucoes/publicosAlvo')->name('publicosAlvo.')->controller(PublicoAlvoController::class)->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    // Páginas estáticas
    Route::view('/acessibilidade', 'acessibilidade')->name('acessibilidade');
    Route::view('/sobre', 'sobre')->name('sobre');
});
