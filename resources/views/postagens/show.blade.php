@extends('layouts.app')

@section('title', $postagem->titulo)

@section('content')
<div class="forum-container">
    <!-- Postagem Principal -->
    <div class="post-card">
        <div class="post-header">
            <div class="post-author">
                <div class="user-icon-circle user-post">
                    <i class="fa fa-user"></i>
                </div>
                <span>Postado por <strong>{{ $postagem->user->name }}</strong></span>
            </div>
            <span>{{ $postagem->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="post-title">{{ $postagem->titulo }}</div>
        <div class="post-content">
            {{ $postagem->conteudo }}
        </div>
    </div>

    <!-- Botão Criar Resposta -->
    <div class="criar-resposta-container">
        <a href="{{ route('respostas.create', $postagem->id) }}" class="btn btn-primary">
            Responder postagem
        </a>
    </div>


    <!-- Respostas -->
    <div class="respostas-container">
        <h3>Respostas ({{ $postagem->respostas->count() }})</h3>

        @foreach($postagem->respostas as $resposta)
        <div class="resposta">
            <img src="{{ $resposta->autor->avatar ?? 'https://i.pravatar.cc/41' }}" alt="Avatar">
            <div class="resposta-conteudo">
                <div class="resposta-autor">{{ $resposta->autor->nome }}</div>
                <div class="resposta-texto">
                    {{ $resposta->conteudo }}
                </div>
                <div class="resposta-data">{{ $resposta->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection