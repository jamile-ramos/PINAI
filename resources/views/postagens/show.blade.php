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
            <!-- Imagem da postagem -->
            @if($postagem->imagem)
            <div class="noticia-imagem">
                <img src="{{ asset('img/imgPostagens/' . $postagem->imagem) }}" alt="{{ $postagem->titulo }}" />
            </div>
            @endif

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
                    <!-- 3 pontinhos -->
                    <div class="post-options">
                        <button class="options-button">
                            <i class="fa fa-ellipsis-v"></i>
                        </button>
                        <div class="options-menu">
                            <a href="">Editar</a>
                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="response-content">
                    {{ $resposta->conteudo }}
                </div>

                <!-- Botão Criar Resposta -->
                <div class="comment-button-container">
                    <button class="btn btn-link comment-toggle" data-id="{{ $resposta->id }}" data-user="$resposta->user->name">
                        <i class="fa fa-reply"></i> Comentar
                    </button>
                </div>

                <!--Comentários nas respostas-->
                <div class="comment-section">
                    <h4>Comentários ({{ $resposta->comentarios->count() }})</h4>

                    @foreach($resposta->comentarios as $comentario)
                    <div class="comment-card">
                        <div class="comment-header">
                            <div class="user-icon-circle">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="comment-info">
                                <span class="comment-username">{{ $comentario->user->name }}</span>
                                <span class="comment-date">{{ $comentario->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="comment-content">
                            {{ $comentario->conteudo }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Formulário para adicionar um comentário -->
                <div class="comment-form-container" id="comment-form-{{ $resposta->id }}" style="display: none;">
                    <form action="{{ route('comentarios.store') }}" method="POST" class="comment-form">
                        @csrf
                        <input type="hidden" name="idResposta" value="{{ $resposta->id }}">
                        <input type="hidden" name="usuarioMencionado" id="usuarioMencionado">
                        <textarea name="conteudo" rows="3" id="comentario-{{ $resposta->id }}" class="form-control mention-input" placeholder="Escreva um comentário..." aria-label="Escreva um comentário"></textarea>
                        <!--Butão de mencionar usuario-->
                        <div class="btn-group-comment">
                        <button class="btn btn-link mention-user" id="mention-user-{{ $resposta->id }}" data-id="{{ $resposta->id}}" data-user="{{ $comentario->user->name }}">
                            <i class="fa fa-at"></i> Mencionar
                        </button>
                        <!-- Menu de sugestões de usuários -->
                        <div class="mention-menu" id="mention-menu-{{ $resposta->id }}" style="display: none;">
                            <ul id="user-list-{{ $resposta->id }}">
                                <!-- Usuários serão inseridos aqui via Ajax -->
                            </ul>
                        </div>

                        <div class="btns-comment">
                            <button type="submit" class="btn btn-primary btn-coment">Comentar</button>
                            <button type="button" class="btn btn-secondary btn-cancelar-comment btn-coment" data-id="{{$resposta->id}}">Cancelar</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Botão Criar Resposta -->
     @if($postagem->respostas->count() != 0)
    <div class="response-button-container">
        <a href="{{ route('respostas.create', $postagem->id) }}" class="btn-response">
            <i class="fa fa-reply"></i> Responder postagem
        </a>
    </div>
    @endif
</div>
@endsection
