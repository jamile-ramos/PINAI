@extends('layouts.app')

@section('title', 'Responder Postagem')

@section('content')
<div class="container my-5">
    <!-- Card com Título, Tópico e Formulário -->
    <div class="card shadow-lg p-4">
        <div class="card-header">
            <h4 class="card-title">Título: {{ $postagem->titulo }}</h4>
        </div>

        <div class="card-body">
            <!-- Exibe o Título e Tópico da Postagem -->
            <div class="post-info mb-4">
                <p class="post-topico">Tópico: {{ $postagem->topico->titulo }}</p>
            </div>

            <!-- Formulário para Criar Resposta -->
            <form action="{{ route('respostas.store', $postagem->id) }}" method="POST">
                @csrf

                <div class="form-group mb-4">
                    <label for="conteudo" class="form-label labelResposta">Sua Resposta</label>
                    <textarea name="conteudo" id="-conteudo" class="form-control" rows="4" placeholder="Escreva sua resposta..." required></textarea>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-resposta">Enviar Resposta</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection