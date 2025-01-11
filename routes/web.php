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
Route::get('/categorias/{tipo}', [CategoriaController::class, 'index'])->name('categorias.index');
Route::post('/categorias/store/{tipo}', [CategoriaController::class, 'store'])->name('categorias.store');