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

    <div class="card shadow-lg p-4">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title"> {{ isset($postagem) ? 'Editar Postagem' : 'Adicionar Postagem' }}</h4>
            </div>
        </div>
        <form id="formpostagem" action="{{ isset($postagem) ? route('postagens.update', $postagem->id) : route('postagens.store') }}" method="post" enctype="multipart/form-data">
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

            <!-- Campo Imagem -->
            <div class="form-group mb-4" id="campoImagem">
                <label for="imagem" class="form-label">Imagem</label>
                <input
                    name="imagem"
                    type="file"
                    class="form-control-file"
                    id="imagem" />
            </div>


            <!-- Prévia da Imagem (se já existir uma imagem) -->
            @if(isset($postagem) && $postagem->imagem)
            <div class="mb-3" id="preview">
                <label for="imagemPreview" class="form-label">Prévia da Imagem</label>
                <img src="{{ asset('img/imgPostagens/'.$postagem->imagem) }}" alt="Prévia da Imagem" class="img-fluid" id="imagemPreview" style="max-width: 300px;">
                <button type="button" class="btn btn-danger mt-2" id="removeImageBtn">Remover Imagem</button>
            </div>
            @endif

            <!-- Campo Tópico -->
            <div class="form-group mb-4">
                <label for="topico" class="form-label">Topico</label>
                <select name="idTopico" class="form-select form-control" id="topico" data-tipo="postagens" required>
                    <option value="" disabled selected>Selecione um topico...</option>
                    @foreach($topicos as $topico)
                    <option value="{{ $topico->id }}"
                        {{ (isset($postagem) && $postagem->idTopico == $topico->id) || (isset($idTopico) && $idTopico == $topico->id) ? 'selected' : '' }}>
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