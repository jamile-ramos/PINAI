@extends('layouts.app')

@section('title', isset($documento) ? 'Editar Documento' : 'Adicionar Documento')

@section('content')

@foreach (['nomeArquivo', 'descricao', 'categoria', 'arquivo'] as $campo)
@error($campo)
<div class="alert alert-danger">{{ $message }}</div>
@enderror
@endforeach

<div class="container my-5">
    <div class="card shadow-lg p-4">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h4 class="card-title"> {{ isset($documento) ? 'Editar Documento' : 'Adicionar Documento' }}</h4>
            </div>
        </div>
        <form id="formDocumento" action="{{ isset($documento) ? route('documentos.update', $documento->id) : route('documentos.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if(isset($documento))
            @method('PUT')
            @endif

            <!-- Campo Nome do arquivo -->
            <div class="form-group mb-4">
                <label for="titulo" class="form-label">Nome do arquivo</label>
                <input
                    name="nomeArquivo"
                    type="text"
                    class="form-control"
                    id="titulo"
                    placeholder="Digite o nome do arquivo"
                    required
                    value="{{ old('nomeArquivo', isset($documento) ? $documento->nomeArquivo : '') }}" />
            </div>

            <!-- Campo Descricao-->
            <div class="form-group mb-4">
                <label for="descricao" class="form-label">Descrição</label>
                <input
                    name="descricao"
                    type="text"
                    class="form-control"
                    id="descricao"
                    placeholder="Digite a descrição"
                    required
                    value="{{ old('descricao', isset($documento) ? $documento->descricao : '') }}" />
            </div>

            <!-- Campo Categoria -->
            <div class="form-group mb-4">
                <label for="categoria" class="form-label">Categoria</label>
                <select name="idCategoria" class="form-select form-control" id="categoria" data-tipo="documentos" required>
                    <option value="" disabled selected>Selecione uma categoria...</option>
                    @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        {{ isset($documento) && $documento->idCategoria == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nomeCategoria }}
                    </option>
                    @endforeach
                </select>
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
                <label for="arquivo" class="form-label px-3 fw-semibold">
                    {{ isset($documento) ? 'Substituir o arquivo (PDF)' : 'Selecione um arquivo para upload (PDF)' }}
                </label>
                <input class="form-control" type="file" id="arquivo" name="arquivo" accept=".pdf,.doc,.docx,.ppt,.pptx" {{ isset($documento) ? '' : 'required' }}>
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