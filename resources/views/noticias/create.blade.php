@extends('layouts.app')

@section('title', 'Adicionar Notícia')

@section('content')

<div class="container my-5">
    <div class="card shadow-lg p-4">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Adicionar Notícia</h4>
            </div>
        </div>
        <form id="formNoticia" action="{{ route('noticias.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Campo Título -->
            <div class="form-group mb-4">
                <label for="titulo" class="form-label">Título</label>
                <input
                    name="titulo"
                    type="text"
                    class="form-control"
                    id="titulo"
                    placeholder="Digite o título da notícia"
                    required />
            </div>

            <!-- Campo Subtítulo -->
            <div class="form-group mb-4">
                <label for="subtitulo" class="form-label">Subtítulo</label>
                <input
                    name="subtitulo"
                    type="text"
                    class="form-control"
                    id="subtitulo"
                    placeholder="Digite o subtítulo"
                    required />
            </div>

            <!-- Campo Conteúdo -->
            <div class="form-group mb-4">
                <label for="conteudo" class="form-label">Conteúdo da Notícia</label>
                <textarea
                    name="conteudo"
                    class="form-control"
                    id="conteudo"
                    rows="20"
                    placeholder="Escreva o conteúdo da notícia"
                    required></textarea>
            </div>

            <!-- Campo Imagem -->
            <div class="form-group mb-4">
                <label for="imagem" class="form-label">Imagem</label>
                <input
                    name="imagem"
                    type="file"
                    class="form-control-file"
                    id="imagem" />
            </div>

            <!-- Campo Categoria -->
            <div class="form-group mb-4">
                <label for="categoria" class="form-label">Categoria</label>
                <select name="categoria" class="form-select form-control" id="categoria" data-tipo="noticias" required>
                    <option value="" disabled selected>Selecione uma categoria...</option>
                    @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nomeCategoria }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botões -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('noticias.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar Notícia</button>
            </div>
        </form>
    </div>
</div>

@endsection