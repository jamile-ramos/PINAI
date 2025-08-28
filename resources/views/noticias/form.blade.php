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

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mt-2 rounded" role="alert">
        <strong>Foram encontrados {{ $errors->count() }} erro(s) no formulário.</strong>
        Verifique os campos destacados abaixo.
        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
    @endif

    <div class="container mb-5">
        <div class="card shadow-lg p-4">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h1 class="fs-5 card-title"> {{ isset($noticia) ? 'Editar Notícia' : 'Adicionar Notícia' }}</h1>
                </div>
            </div>
            <form id="formNoticia" action="{{ isset($noticia) ? route('noticias.update', $noticia->id) : route('noticias.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($noticia))
                @method('PUT')
                @endif

                <!-- Campo Título -->
                <div class="form-group ">
                    <label for="titulo" class="form-label fw-bold">Título <span class="text-danger">*</span><span class="visually-hidden">(campo obrigatório)</span></label>
                    <input
                        name="titulo"
                        type="text"
                        class="form-control @error('titulo') is-invalid @enderror"
                        aria-describedby="@error('titulo') error-titulo @enderror"
                        id="titulo"
                        placeholder="Digite o título da notícia"
                        required
                        value="{{ old('titulo', isset($noticia) ? $noticia->titulo : '') }}" />
                    @error('titulo')
                    <div id="error-titulo" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Campo Subtítulo -->
                <div class="form-group ">
                    <label for="subtitulo" class="form-label fw-bold">Subtítulo <span class="text-danger">*</span><span class="visually-hidden">(campo obrigatório)</span></label>
                    <input
                        name="subtitulo"
                        type="text"
                        class="form-control @error('subtitulo') is-invalid @enderror"
                        aria-describedby="@error('subtitulo') error-subtitulo @enderror"
                        id="subtitulo"
                        placeholder="Digite o subtítulo"
                        required
                        value="{{ old('subtitulo', isset($noticia) ? $noticia->subtitulo : '') }}" />

                    @error('subtitulo')
                    <div id="error-subtitulo" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Campo Conteúdo -->
                <div class="form-group mb-4">
                    <label for="conteudo" class="form-label fw-bold">Conteúdo da Notícia <span class="text-danger">*</span><span class="visually-hidden">(campo obrigatório)</span></label>
                    <textarea
                        name="conteudo"
                        class="form-control @error('conteudo') is-invalid @enderror"
                        aria-describedby="@error('conteudo') error-conteudo @enderror"
                        id="conteudo"
                        rows="20"
                        placeholder="Escreva o conteúdo da notícia">{{ old('conteudo', isset($noticia) ? $noticia->conteudo : '') }}</textarea>

                    @error('conteudo')
                    <div id="error-conteudo" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Campo Imagem -->
                <div class="px-3 mb-3" id="campoImagem">
                    <label for="imagem" class="form-label fw-bold fw-bold">
                        Imagem
                    </label>
                    <input
                        name="imagem"
                        type="file"
                        class="form-control @error('imagem') is-invalid @enderror"
                        aria-describedby="@error('imagem') error-imagem @enderror"
                        id="imagem"
                        tabindex="0" />

                    @error('imagem')
                    <div id="error-imagem" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Prévia da Imagem (se já existir uma imagem) -->
                @if(isset($noticia) && $noticia->imagem)
                <div class="mb-3" id="preview">
                    <label for="imagemPreview" class="form-label fw-bold">Prévia da Imagem</label>
                    <img
                        src="{{ asset('img/imgNoticias/'.$noticia->imagem) }}"
                        alt="Prévia da imagem atual da notícia"
                        class="img-fluid"
                        id="imagemPreview"
                        style="max-width: 300px;">

                    <button
                        type="button"
                        class="btn btn-danger mt-2"
                        id="removeImageBtn"
                        aria-controls="imagemPreview"
                        aria-label="Remover a imagem atual da notícia">
                        Remover Imagem
                    </button>
                </div>
                @endif


                <!-- Campo Categoria -->
                <div class="form-group ">
                    <label for="categoria" class="form-label fw-bold">Categoria <span class="text-danger">*</span><span class="visually-hidden">(campo obrigatório)</span></label>
                    <select name="idCategoria"
                        class="form-select form-control @error('idCategoria') is-invalid @enderror"
                        aria-describedby="@error('idCategoria') error-idCategoria @enderror" id="categoria" data-tipo="noticias" required>
                        <option value="" disabled selected>Selecione uma categoria...</option>
                        @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ isset($noticia) && $noticia->idCategoria == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nomeCategoria }}
                        </option>
                        @endforeach
                    </select>
                    @error('idCategoria')
                    <div id="error-idCategoria" class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Botões -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('noticias.index') }}" class="btn btn-secondary" aria-label="Cancelar e voltar para a lista de notícias">Cancelar</a>
                    <button type="submit" class="btn btn-primary">{{ isset($noticia) ? 'Atualizar Notícia' : 'Salvar Notícia' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection