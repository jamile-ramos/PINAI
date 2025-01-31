<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\NoticiaController;

Route::middleware('guest')->get('/', function () {
    return view('auth.login'); 
});

Route::get('/dashboard', function () {
    return view('dashboard');
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