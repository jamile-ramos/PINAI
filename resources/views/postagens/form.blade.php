@extends('layouts.app')

@section('title', isset($postagem) ? 'Editar Postagem' : 'Adicionar Postagem')

@section('content')

@php
$tipoForm = isset($postagem) ? 'Editar Postagem' : 'Adicionar Postagem';
if(isset($idTopico)){
$idTopico = $idTopico;
}else{
$idTopico = $postagem->idTopico;
}
@endphp

<div class="container my-5">

    <div class="px-2">
        {{ Breadcrumbs::render('formPostagem', $idTopico, $tipoForm)}}
    </div>

    @if ($errors->any())
    @foreach ($errors->all() as $message)
    <div class="alert alert-danger alert-dismissible fade show mt-2 mx-3 rounded" role="alert">
        {{ $message }}
        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Fechar">
        </button>
    </div>
    @endforeach
    @endif

    <div class="card shadow-lg p-4">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h1 class="fs-5 card-title"> {{ isset($postagem) ? 'Editar Postagem' : 'Adicionar Postagem' }}</h1>
            </div>
        </div>
        <form id="formpostagem" action="{{ isset($postagem) ? route('postagens.update', $postagem->id) : route('postagens.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if(isset($postagem))
            @method('PUT')
            @endif

            <!-- Campo Título -->
            <div class="form-group mb-4">
                <label for="titulo" class="form-label fw-bold">Título <span class="text-danger">*</span><span class="visually-hidden">(campo obrigatório)</span></label>
                <input
                    name="titulo"
                    type="text"
                    class="form-control @error('titulo') is-invalid @enderror"
                    aria-describedby="@error('titulo') error-titulo @enderror"
                    id="titulo"
                    placeholder="Digite o título da postagem"
                    required
                    value="{{ old('titulo', isset($postagem) ? $postagem->titulo : '') }}" />
                @error('titulo')
                <div id="error-titulo" class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Campo Conteúdo -->
            <div class="form-group mb-4">
                <label for="conteudo" class="form-label fw-bold">Conteúdo da Postagem <span class="text-danger">*</span><span class="visually-hidden">(campo obrigatório)</span></label>
                <textarea
                    name="conteudo"
                    class="form-control @error('conteudo') is-invalid @enderror"
                    aria-describedby="@error('conteudo') error-conteudo @enderror"
                    id="conteudo"
                    rows="10"
                    placeholder="Escreva o conteúdo da postagem"
                    required>{{ old('conteudo', isset($postagem) ? $postagem->conteudo : '') }}</textarea>
                @error('conteudo')
                <div id="error-conteudo" class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Campo Imagem -->
            <div class="px-3" id="campoImagem">
                <label for="imagem" class="form-label fw-bold">
                    Imagem
                </label>
                <input
                    name="imagem"
                    type="file"
                    class="form-control @error('imagem') is-invalid @enderror"
                    aria-describedby="@error('imagem') error-titulo @enderror"
                    id="imagem"
                    tabindex="0" />
                @error('imagem')
                <div id="error-imagem" class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Prévia da Imagem (se já existir uma imagem) -->
            @if(isset($postagem) && $postagem->imagem)
            <div class="mb-3" id="preview">
                <label for="imagemPreview" class="form-label fw-bold">Prévia da Imagem</label>
                <img src="{{ asset('img/imgPostagens/'.$postagem->imagem) }}" alt="Prévia da Imagem" class="img-fluid" id="imagemPreview" style="max-width: 300px;">
                <button type="button" class="btn btn-danger mt-2" id="removeImageBtn">Remover Imagem</button>
            </div>
            @endif

            <!-- Campo Tópico -->
            <div class="form-group mb-4">
                <label for="topico" class="form-label fw-bold">Topico <span class="text-danger">*</span><span class="visually-hidden">(campo obrigatório)</span></label>
                <select name="idTopico" class="form-select form-control @error('idTopico') is-invalid @enderror"
                    aria-describedby="@error('idTopico') error-idTopico @enderror" id="topico" data-tipo="postagens" required>
                    <option value="" disabled selected>Selecione um topico...</option>
                    @foreach($topicos as $topico)
                    <option value="{{ $topico->id }}"
                        {{ (isset($postagem) && $postagem->idTopico == $topico->id) || (isset($idTopico) && $idTopico == $topico->id) ? 'selected' : '' }}>
                        {{ $topico->titulo }}
                    </option>
                    @endforeach
                </select>
                @error('idTopico')
                <div id="error-idTopico" class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
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