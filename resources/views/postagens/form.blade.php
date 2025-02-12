@extends('layouts.app')

@section('title', isset($postagem) ? 'Editar Postagem' : 'Adicionar Postagem')

@section('content')

<div class="container my-5">
    <div class="card shadow-lg p-4">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title"> {{ isset($postagem) ? 'Editar Postagem' : 'Adicionar Postagem' }}</h4>
            </div>
        </div>
        <form id="formpostagem" action="{{ isset($postagem) ? route('postagens.update', $postagem->id) : route('postagens.store') }}" method="post">
            @csrf
            @if(isset($postagem))
            @method('PUT')
            @endif

            <!-- Campo Título -->
            <div class="form-group mb-4">
                <label for="titulo" class="form-label">Título</label>
                <input
                    name="titulo"
                    type="text"
                    class="form-control"
                    id="titulo"
                    placeholder="Digite o título da postagem"
                    required
                    value="{{ old('titulo', isset($postagem) ? $postagem->titulo : '') }}" />
            </div>

            <!-- Campo Conteúdo -->
            <div class="form-group mb-4">
                <label for="conteudo" class="form-label">Conteúdo da Postagem</label>
                <textarea
                    name="conteudo"
                    class="form-control"
                    id="conteudo"
                    rows="10"
                    placeholder="Escreva o conteúdo da postagem"
                    required>{{ old('conteudo', isset($postagem) ? $postagem->conteudo : '') }}</textarea>
            </div>

            <!-- Campo Categoria -->
            <div class="form-group mb-4">
                <label for="topico" class="form-label">Topico</label>
                <select name="idTopico" class="form-select form-control" id="topico" data-tipo="postagens" required>
                    <option value="" disabled selected>Selecione um topico...</option>
                    @foreach($topicos as $topico)
                    <option value="{{ $topico->id }}"
                        {{ isset($postagem) && $postagem->idTopico == $topico->id ? 'selected' : '' }}>
                        {{ $topico->titulo }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Botões -->
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancelar</button>
                <button type="submit" class="btn btn-primary">{{ isset($postagem) ? 'Atualizar Postagem' : 'Salvar Postagem' }}</button>
            </div>
        </form>
    </div>
</div>

@endsection