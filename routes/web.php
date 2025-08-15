<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
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
    Route::get('/painelUsuarios', [UsuarioController::class, 'index'])->name('painel.usuarios');
    Route::put('/painelUsuarios/alterar/{id}', [UsuarioController::class, 'update'])->name('painel.update');
    Route::put('/painelUsuarios/status/{id}', [UsuarioController::class, 'updateStatus'])->name('painel.updateStatus');
    // Nais
    Route::get('painelUsuarios/nais/create', [NaiController::class, 'create'])->name('nais.create');
    Route::post('painelUsuarios/nais/store', [NaiController::class, 'store'])->name('nais.store');
    Route::put('painelUsuarios/nais/update/{id}', [NaiController::class, 'update'])->name('nais.update');
    Route::get('painelUsuarios/nais/edit/{id}', [NaiController::class, 'edit'])->name('nais.edit');
    Route::get('painelUsuarios/nais/show/{id}', [NaiController::class, 'show'])->name('nais.show');
    Route::delete('painelUsuarios/nais/destroy/{id}', [NaiController::class, 'destroy'])->name('nais.destroy');

    // Portal de Notícias
    Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
    Route::get('/noticias/create', [NoticiaController::class, 'create'])->name('noticias.create');
    Route::post('/noticias/store', [NoticiaController::class, 'store'])->name('noticias.store');
    Route::delete('/noticias/destroy/{id}', [NoticiaController::class, 'destroy'])->name('noticias.destroy');
    Route::get('/noticias/edit/{id}', [NoticiaController::class, 'edit'])->name('noticias.edit');
    Route::put('/noticias/update/{id}', [NoticiaController::class, 'update'])->name('noticias.update');
    Route::get('/noticias/show/{id}', [NoticiaController::class, 'show'])->name('noticias.show');
    Route::get('/noticias/categorias/{idCategoria}', [NoticiaController::class, 'noticiasCategorias'])->name('noticias.noticiasCategorias');

    // Categorias de noticias, topicos, documentos e solucoes
    Route::get('/categorias/create/{tipo}', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias/store/{tipo}', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::delete('/categorias/destroy/{tipo}/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

    // Fórum de Discurssão
    Route::get('/topicos', [TopicoController::class, 'index'])->name('topicos.index');
    Route::get('/topicos/create', [TopicoController::class, 'create'])->name('topicos.create');
    Route::post('/topicos/store', [TopicoController::class, 'store'])->name('topicos.store');
    Route::delete('/topicos/destroy/{id}', [TopicoController::class, 'destroy'])->name('topicos.destroy');
    //Route::get('/topicos/sugestao', [TopicoController::class, 'storeSugestao'])->name('topicos.storeSugestao');
    Route::get('/topicos/edit/{id}', [TopicoController::class, 'edit'])->name('topicos.edit');
    Route::put('/topicos/update/{id}', [TopicoController::class, 'update'])->name('topicos.update');

    // Postagens dos tópicos
    Route::get('/postagens/{idTopico}', [PostagemController::class, 'index'])->name('postagens.index');
    Route::get('/postagens/create/{idTopico}', [PostagemController::class, 'create'])->name('postagens.create');
    Route::post('/postagens/store', [PostagemController::class, 'store'])->name('postagens.store');
    Route::get('/postagens/edit/{id}', [PostagemController::class, 'edit'])->name('postagens.edit');
    Route::put('/postagens/update/{id}', [PostagemController::class, 'update'])->name('postagens.update');
    Route::delete('/postagens/destroy/{id}', [PostagemController::class, 'destroy'])->name('postagens.destroy');
    Route::get('/postagens/show/{id}', [PostagemController::class, 'show'])->name('postagens.show');

    // Resposta dos posts
    Route::get('/respostas/create/{idPostagem}', [RespostaController::class, 'create'])->name('respostas.create');
    Route::post('/respostas/store/{idPostagem}', [RespostaController::class, 'store'])->name('respostas.store');
    Route::get('/respostas/edit/{idResposta}', [RespostaController::class, 'edit'])->name('respostas.edit');
    Route::put('/respostas/update/{idResposta}', [RespostaController::class, 'update'])->name('respostas.update');
    Route::delete('/respostas/destroy/{id}', [RespostaController::class, 'destroy'])->name('respostas.destroy');

    // Comentarios das respostas
    Route::post('/comentarios/store', [ComentarioController::class, 'store'])->name('comentarios.store');
    Route::get('/comentarios/usuarios/{idResposta}', [ComentarioController::class, 'usuariosDaResposta'])->name('comentarios.usuarios');

    // Sugestão de tópicos
    Route::post('/sugestoes/store', [SugestaoTopicoController::class, 'store'])->name('sugestoes.store');
    Route::delete('/sugestoes/destroy/{id}', [SugestaoTopicoController::class, 'destroy'])->name('sugestoes.destroy');
    Route::put('/sugestoes/statusSituacao/{id}', [SugestaoTopicoController::class, 'updateStatusSituacao'])->name('sugestoes.updateStatusSituacao');

    // Documentos (Biblioteca Digital)
    Route::get('/documentos', [DocumentoController::class, 'index'])->name('documentos.index');
    Route::get('/documentos/create', [DocumentoController::class, 'create'])->name('documentos.create');
    Route::post('/documentos/store', [DocumentoController::class, 'store'])->name('documentos.store');
    Route::get('/documentos/edit/{id}', [DocumentoController::class, 'edit'])->name('documentos.edit');
    Route::put('/documentos/update/{id}', [DocumentoController::class, 'update'])->name('documentos.update');
    Route::get('/documentos/categorias/{idCategoria}', [DocumentoController::class, 'documentosCategorias'])->name('documentos.documentosCategorias');
    Route::delete('documentos/destroy/{id}', [DocumentoController::class, 'destroy'])->name('documentos.destroy');

    // Solucões (Banco de Soluções)
    Route::get('/solucoes', [SolucaoController::class, 'index'])->name('solucoes.index');
    Route::get('/solucoes/create', [SolucaoController::class, 'create'])->name('solucoes.create');
    Route::post('/solucoes/store', [SolucaoController::class, 'store'])->name('solucoes.store');
    Route::put('/solucoes/update/{id}', [SolucaoController::class, 'update'])->name('solucoes.update');
    Route::get('/solucoes/show/{id}', [SolucaoController::class, 'show'])->name('solucoes.show');
    Route::get('/solucoes/edit/{id}', [SolucaoController::class, 'edit'])->name('solucoes.edit');
    Route::delete('/solucoes/destroy/{id}', [SolucaoController::class, 'destroy'])->name('solucoes.destroy');
    Route::get('/solucoes/categorias/{idCategoria}', [SolucaoController::class, 'solucoesCategorias'])->name('solucoes.solucoesCategorias');

    // Público alvo de soluções
    Route::get('/solucoes/publicosAlvo/create', [PublicoAlvoController::class, 'create'])->name('publicosAlvo.create');
    Route::post('/solucoes/publicosAlvo/store', [PublicoAlvoController::class, 'store'])->name('publicosAlvo.store');
    Route::delete('/solucoes/publicosAlvo/destroy/{id}', [PublicoAlvoController::class, 'destroy'])->name('publicosAlvo.destroy');
});
