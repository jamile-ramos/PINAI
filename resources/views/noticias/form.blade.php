@extends('layouts.app')

@section('title', isset($noticia) ? 'Editar Notícia' : 'Adicionar Notícia')

@section('content')

<div class="col">
    <div class="mx-4">
        @php
        $tipoForm =isset($noticia) ? 'Editar Noticia' : 'Adicionar Noticia'
        @endphp
        {{ Breadcrumbs::render('formNoticia', $tipoForm)}}
    </div>
    <div class="container my-5">
        <div class="card shadow-lg p-4">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"> {{ isset($noticia) ? 'Editar Notícia' : 'Adicionar Notícia' }}</h4>
                </div>
            </div>
            <form id="formNoticia" action="{{ isset($noticia) ? route('noticias.update', $noticia->id) : route('noticias.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($noticia))
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
                        placeholder="Digite o título da notícia"
                        required
                        value="{{ old('titulo', isset($noticia) ? $noticia->titulo : '') }}" />
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
                        required
                        value="{{ old('subtitulo', isset($noticia) ? $noticia->subtitulo : '') }}" />
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
                        required>{{ old('conteudo', isset($noticia) ? $noticia->conteudo : '') }}</textarea>
                </div>

                <!-- Campo Imagem -->
                <div class="form-group mb-4" id="campoImagem">
                    <label for="imagem" class="form-label">Imagem</label>
                    <div class="custom-file-container">
                        <input
                            name="imagem"
                            type="file"
                            class="form-control-file"
                            id="imagem"
                            tabindex="0" />
                        <label for="imagem" class="custom-file-label">Escolher Arquivo</label>
                    </div>
                </div>


                <!-- Prévia da Imagem (se já existir uma imagem) -->
                @if(isset($noticia) && $noticia->imagem)
                <div class="mb-3" id="preview">
                    <label for="imagemPreview" class="form-label">Prévia da Imagem</label>
                    <img src="{{ asset('img/imgNoticias/'.$noticia->imagem) }}" alt="Prévia da Imagem" class="img-fluid" id="imagemPreview" style="max-width: 300px;">
                    <button type="button" class="btn btn-danger mt-2" id="removeImageBtn">Remover Imagem</button>
                </div>
                @endif

                <!-- Campo Categoria -->
                <div class="form-group mb-4">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select name="idCategoria" class="form-select form-control" id="categoria" data-tipo="noticias" required>
                        <option value="" disabled selected>Selecione uma categoria...</option>
                        @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ isset($noticia) && $noticia->idCategoria == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nomeCategoria }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Botões -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('noticias.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">{{ isset($noticia) ? 'Atualizar Notícia' : 'Salvar Notícia' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection