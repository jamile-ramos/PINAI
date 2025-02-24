<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\PostagemController;
use App\Http\Controllers\RespostaController;
use App\Http\Controllers\SugestaoTopicoController;
use App\Http\Controllers\TopicoController;
use App\Models\Noticia;

Route::middleware('guest')->get('/', function () {
    return view('auth.login'); 
});

Route::get('/dashboard', function () {
    $noticias = Noticia::latest()->take(3)->get();
    return view('dashboard', compact('noticias'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Painel de usuários
Route::get('/painelUsuarios', [UsuarioController::class, 'index'])->name('painel.usuarios');
Route::put('/painelUsuarios/alterar/{id}', [UsuarioController::class, 'update'])->name('painel.update');
Route::put('/painelUsuarios/status/{id}', [UsuarioController::class, 'updateStatus'])->name('painel.updateStatus');

// Portal de Notícias
Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/create', [NoticiaController::class, 'create'])->name('noticias.create');
Route::post('/noticias/store', [NoticiaController::class, 'store'])->name('noticias.store');
Route::delete('/noticias/delete', [NoticiaController::class, 'delete'])->name('noticias.delete');
Route::get('/noticias/edit/{id}', [NoticiaController::class, 'edit'])->name('noticias.edit');
Route::put('/noticias/update/{id}', [NoticiaController::class, 'update'])->name('noticias.update');
Route::get('/noticias/show/{id}', [NoticiaController::class, 'show'])->name('noticias.show');
Route::get('/noticias/categorias/{idCategoria}', [NoticiaController::class, 'noticiasCategorias'])->name('noticias.noticiasCategorias');

// Categorias de noticias, topicos, documentos e solucoes
Route::get('/categorias/create/{tipo}', [CategoriaController::class, 'create'])->name('categorias.create');
Route::post('/categorias/store/{tipo}', [CategoriaController::class, 'store'])->name('categorias.store');
Route::delete('/categorias/delete/{tipo}', [CategoriaController::class, 'delete'])->name('categorias.delete');

// Fórum de Discurssão
Route::get('/topicos', [TopicoController::class, 'index'])->name('topicos.index');
Route::get('/topicos/create', [TopicoController::class, 'create'])->name('topicos.create');
Route::post('/topicos/store', [TopicoController::class, 'store'])->name('topicos.store');
Route::delete('/topicos/delete', [TopicoController::class, 'delete'])->name('topicos.delete');
Route::get('/topicos/sugestao', [TopicoController::class, 'storeSugestao'])->name('topicos.storeSugestao');
Route::get('/topicos/edit/{id}', [TopicoController::class, 'edit'])->name('topicos.edit');
Route::put('/topicos/update/{id}', [TopicoController::class, 'update'])->name('topicos.update');

// Postagens dos tópicos
Route::get('/postagens/create', [PostagemController::class, 'create'])->name('postagens.create');
Route::post('/postagens/store', [PostagemController::class, 'store'])->name('postagens.store');
Route::get('/postagens/{id}', [PostagemController::class, 'index'])->name('postagens.index');
Route::get('/postagens/edit/{id}', [PostagemController::class, 'edit'])->name('postagens.edit');
Route::put('/postagens/update/{id}', [PostagemController::class, 'update'])->name('postagens.update');
Route::delete('/postagens/delete', [PostagemController::class, 'delete'])->name('postagens.delete');
Route::get('/postagens/show/{id}', [PostagemController::class, 'show'])->name('postagens.show');

// Resposta dos posts
Route::get('/respostas/create/{id}', [RespostaController::class, 'create'])->name('respostas.create');
Route::post('/respostas/store/{id}', [RespostaController::class, 'store'])->name('respostas.store');

//Comentarios das respostas
Route::post('/comentarios/store', [ComentarioController::class, 'store'])->name('comentarios.store');

// Sugestão de tópicos
Route::post('/sugestoes/store', [SugestaoTopicoController::class, 'store'])->name('sugestoes.store');
Route::delete('/sugestoes/delete', [SugestaoTopicoController::class, 'delete'])->name('sugestoes.delete');
Route::put('/sugestoes/status/{id}', [SugestaoTopicoController::class, 'updateStatus'])->name('sugestoes.updateStatus');
