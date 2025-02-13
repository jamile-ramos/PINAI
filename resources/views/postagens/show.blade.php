@extends('layouts.app')

@section('title', $postagem->titulo)

@section('content')
<div class="forum-wrapper">
    <!-- Postagem Principal -->
    <div class="postagem-completa">
        <div class="main-post-card">
            <div class="main-post-header">
                <div class="post-author">
                    <div class="user-icon-circle user-post">
                        <i class="fa fa-user"></i>
                    </div>
                    <span>Postado por <strong>{{ $postagem->user->name }}</strong></span>
                </div>
                <span class="post-date">{{ $postagem->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="main-post-title">{{ $postagem->titulo }}</div>
            <div class="main-post-content">
                {{ $postagem->conteudo }}
            </div>
            <div class="response-button-container">
                <a href="{{ route('respostas.create', $postagem->id) }}" class="btn-response">
                    <i class="fa fa-reply"></i> Responder postagem
                </a>
            </div>
        </div>

        <!-- Respostas -->
        <div class="respostas-container">
            <h3 class="responses-title">Respostas ({{ $postagem->respostas->count() }})</h3>

            @foreach($postagem->respostas as $resposta)
            <div class="response-card">
                <div class="response-header">
                    <div class="user-icon-circle user-post">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="response-info">
                        <span class="response-username">{{ $resposta->user->name }}</span>
                        <span class="response-date">{{ $resposta->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div class="response-content">
                    {{ $resposta->conteudo }}
                </div>

                <!-- Comentários nas respostas -->
                <div class="comment-section">
                    <h4>Comentários</h4>
                    <div class="comment-card">
                        <div class="comment-header">
                            <div class="user-icon-circle">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="comment-info">
                                <span class="comment-username">Nome</span>
                                <span class="comment-date">12/02/25</span>
                            </div>
                        </div>
                        <div class="comment-content">
                            Teste
                        </div>
                    </div>
                </div>

                <!-- Formulário para adicionar um comentário -->
                <div class="comment-form-container">
                    <h5 class="response-being-commented">Comentando na resposta: <strong>{{ \Str::limit($resposta->conteudo, 100) }}</strong></h5>
                    <form action="" method="POST">
                        @csrf
                        <div>
                            <textarea name="conteudo" rows="3" class="form-control" placeholder="Escreva um comentário..." aria-label="Escreva um comentário"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-response btn-coment">Comentar</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Botão Criar Resposta -->
    <div class="response-button-container">
        <a href="{{ route('respostas.create', $postagem->id) }}" class="btn-response">
            <i class="fa fa-reply"></i> Responder postagem
        </a>
    </div>
</div>
@endsection