@extends('layouts.app')

@section('title', 'Criar)

@section('content')

<form id="formNoticia" action="{{ route('noticias.create') }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- Campo Título -->
    <div class="form-group">
        <label for="titulo">Título</label>
        <input
            name="titulo"
            type="text"
            class="form-control form-control"
            id="titulo"
            placeholder="Digite o subtítulo" />
    </div>

    <!-- Campo Subtítulo -->
    <div class="form-group">
        <label for="subtitulo">Subtítulo</label>
        <input
            name="subtitulo"
            type="text"
            class="form-control form-control"
            id="subtitulo"
            placeholder="Digite o subtítulo" />
    </div>

    <!-- Campo Conteúdo -->
    <div class="form-group">
        <label for="conteudo">Conteúdo da notícia</label>
        <textarea
            name="conteudo"
            class="form-control"
            id="conteudo"
            rows="10"></textarea>
    </div>

    <!-- Campo Imagem -->
    <div class="form-group" id="campo-imagem">
        <label for="imagem">Imagem</label>
        <input
            name="imagem"
            type="file"
            class="form-control-file"
            id="imagem" />
    </div>

    <!-- Campo Categoria -->
    <div class="form-group">
        <label for="categoria">Categoria</label>
        <select name="categoria" class="form-select form-control" id="categoria" data-tipo='noticias'>
            <option value="" disabled selected>Carregando categorias...</option>
        </select>
    </div>

</form>

@endsection