@extends('layouts.app')

@section('title', isset($noticia) ? 'Editar Núcleo de Acessibilidade e Inclusão' : 'Adicionar Núcleo de Acessibilidade e Inclusão')

@section('content')

<div class="col">
    <div class="mx-4">
        @php
        $tipoForm =isset($noticia) ? 'Editar Núcleo de Acessibilidade e Inclusão' : 'Adicionar Núcleo de Acessibilidade e Inclusão'
        @endphp
        {{ Breadcrumbs::render('formNai', $tipoForm)}}
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

                <!-- Campo Nome -->
                <div class="form-group mb-4">
                    <label for="nome" class="form-label">Nome</label>
                    <input
                        name="nome"
                        type="text"
                        class="form-control"
                        id="nome"
                        placeholder="Digite o nome do Núcleo de Acessibilidade e Inclusão"
                        required
                        value="{{ old('nome', isset($noticia) ? $noticia->titulo : '') }}" />
                </div>

                <!-- Campo Instituição-->
                <div class="form-group mb-4">
                    <label for="instituicao" class="form-label">Instituição</label>
                    <input
                        name="instituicao"
                        type="text"
                        class="form-control"
                        id="instituicao"
                        placeholder="Digite a instituição"
                        required
                        value="{{ old('instituicao', isset($noticia) ? $noticia->instituicao : '') }}" />
                </div>

                <!-- Campo sigla da Instituicao -->
                <div class="form-group mb-4">
                    <label for="siglaInstituicao" class="form-label">Sigla da Intituição</label>
                    <input
                        name="siglaInstituicao"
                        type="text"
                        class="form-control"
                        id="siglaInstituicao"
                        placeholder="Digite a sigla da Instituicao"
                        required
                        value="{{ old('siglaInstituicao', isset($noticia) ? $noticia->siglaInstituicao : '') }}" />
                </div>

                <!-- Campo Estados brasileiros -->
                <div class="form-group mb-4">
                    <label for="estados" class="form-label">Estado</label>
                    <select name="idEstado" class="form-select form-control" id="estado" data-tipo="estado" required>
                        <option value="" disabled selected>Selecione um estado...</option>
                        @foreach($estados as $sigla => $nome)
                        <option value="{{ $sigla }}">{{ $sigla }} - {{ $nome }}</option>
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