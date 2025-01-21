@extends('layouts.app')

@section('title', 'Editar Notícia')

@section('content')

<div class="container my-5">
    <div class="card shadow-lg p-4">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Editar Notícia</h4>
            </div>
        </div>
        <form id="formNoticiaEdit" action="{{ route('noticias.update', $noticia->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Campo Título -->
            <div class="form-group mb-4">
                <label for="titulo" class="form-label">Título</label>
                <input
                    name="titulo"
                    type="text"
                    class="form-control"
                    id="titulo"
                    value="{{ $noticia->titulo }}"
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
                    value="{{ $noticia->subtitulo }}"
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
                    required>{{ $noticia->conteudo }}</textarea>
            </div>

            <!-- Campo Imagem -->
            <div class="form-group mb-4 campo-img-edit">
                <label for="imagem" class="form-label">Imagem</label>
                <input
                    name="imagem"
                    type="file"
                    class="form-control-file"
                    id="imagem" />
            </div>

            @if($noticia->imagem)
            <div id="imagem-preview-container-edit">
                <img id="imagem-preview-edit" src="{{ asset('img/imgNoticias/' . $noticia->imagem) }}" alt="Imagem Atual">
                <button type="button" id="remove-imagem-edit" class="btn btn-danger">Remover</button>
            </div>
            @endif

            <!-- Campo Categoria -->
            <div class="form-group mb-4">
                <label for="categoria" class="form-label">Categoria</label>
                <select name="categoria" class="form-select form-control" id="categoria" data-tipo="noticias" required>
                    <option value="" disabled>Selecione uma categoria...</option>
                    @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        @if($categoria->id == $noticia->categoria->id) selected @endif>
                        {{ $categoria->nomeCategoria }}
                    </option>
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