@extends('layouts.app')

@section('title', isset($documento) ? 'Editar Documento' : 'Adicionar Documento')

@section('content')

@php
$tipoForm = isset($documento) ? 'Editar Documento' : 'Adicionar Documento';
@endphp

<div class="container">
    <div class="mx-3">
        {{ Breadcrumbs::render('formDocumento', $tipoForm) }}
    </div>

    @if ($errors->any())
    @foreach ($errors->all() as $message)
    <div class="alert alert-danger alert-dismissible fade show mt-2 mx-2 rounded" role="alert">
        {{ $message }}
        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Fechar">
        </button>
    </div>
    @endforeach
    @endif

    <div class="card shadow-lg p-4">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h1 class="fs-5 card-title"> {{ isset($documento) ? 'Editar Documento' : 'Adicionar Documento' }}</h1>
            </div>
        </div>
        <form id="formDocumento" action="{{ isset($documento) ? route('documentos.update', $documento->id) : route('documentos.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if(isset($documento))
            @method('PUT')
            @endif

            <!-- Campo Nome do arquivo -->
            <div class="form-group mb-4">
                <label for="titulo" class="form-label fw-bold">Nome do arquivo <span class="text-danger">*</span><span class="visually-hidden">(campo obrigatório)</span></label>
                <input
                    name="nomeArquivo"
                    type="text"
                    class="form-control @error('nomeArquivo') is-invalid @enderror"
                    aria-describedby="@error('nomeArquivo') error-nomeArquivo @enderror"
                    id="titulo"
                    placeholder="Digite o nome do arquivo"
                    required
                    value="{{ old('nomeArquivo', isset($documento) ? $documento->nomeArquivo : '') }}" />
                @error('nomeArquivo')
                <div id="error-nomeArquivo" class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Campo Descricao-->
            <div class="form-group mb-4">
                <label for="descricao" class="form-label fw-bold">Descrição <span class="text-danger">*</span><span class="visually-hidden">(campo obrigatório)</span></label>
                <input
                    name="descricao"
                    type="text"
                    class="form-control @error('descricao') is-invalid @enderror"
                    aria-describedby="@error('descricao') error-descricao @enderror"
                    id="descricao"
                    placeholder="Digite a descrição"
                    required
                    value="{{ old('descricao', isset($documento) ? $documento->descricao : '') }}" />
                @error('descricao')
                <div id="error-descricao" class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Campo Categoria -->
            <div class="form-group mb-4">
                <label for="categoria" class="form-label fw-bold">Categoria <span class="text-danger">*</span><span class="visually-hidden">(campo obrigatório)</span></label>
                <select name="idCategoria" class="form-select form-control @error('idCategoria') is-invalid @enderror"
                    aria-describedby="@error('idCategoria') error-idCategoria @enderror" id="categoria" data-tipo="documentos" required>
                    <option value="" disabled selected>Selecione uma categoria...</option>
                    @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        {{ isset($documento) && $documento->idCategoria == $categoria->id ? 'selected' : '' }}>
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

            <div class="p-3 mb-4 rounded border border-info text-dark bg-info-subtle">
                📌 Você pode enviar <strong>somente um link externo</strong>,
                <strong> um arquivo (PDF...)</strong>
                ou <strong>os dois</strong>.
                Pelo menos <u>um dos campos</u> deve ser preenchido.
            </div>


            <div class="form-group mb-4">
                <label for="link" class="form-label fw-bold">Link de arquivo</label>
                <input
                    type="url"
                    name="link"
                    id="link"
                    class="form-control"
                    placeholder="Ex: https://www.youtube.com/watch?v=XXXXXX"
                    value="{{ old('link', $documento->link ?? '') }}">
            </div>

            <!-- Prévia do documento existente -->
            @if(isset($documento) && $documento->caminhoArquivo)
            <div class="mb-3 d-block" id="previaDocumento">
                <p class="mb-1 fw-semibold text-muted px-3">Arquivo atual:</p>
                <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}" target="_blank" class="btn btn-link">
                    <i class="fa fa-eye"></i> Visualizar documento atual
                </a>
            </div>
            @endif

            <!-- Upload de novo arquivo -->
            <div class="mb-3">
                <label for="arquivo" class="form-label fw-bold px-3 fw-semibold">
                    {{ isset($documento) ? 'Substituir o arquivo (PDF)' : 'Selecione um arquivo para upload (PDF)' }}
                </label>
                <input type="file" id="arquivo" name="arquivo"
                    class="form-control @error('arquivo') is-invalid @enderror"
                    aria-describedby="@error('arquivo') error-arquivo @enderror" accept=".pdf,.doc,.docx,.ppt,.pptx">
                @error('idCategoria')
                <div id="error-idCategoria" class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
            </div>



            <!-- Botões -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('documentos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">{{ isset($documento) ? 'Atualizar Documento' : 'Salvar Documento' }}</button>
            </div>
        </form>
    </div>
</div>

@endsection