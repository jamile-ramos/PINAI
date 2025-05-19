@extends('layouts.app')

@section('title', isset($solucao) ? 'Editar Solução' : 'Adicionar Solução')

@section('content')

@php
$tipoForm = isset($solucao) ? 'Editar Solução' : 'Adicionar Solução';
@endphp
<div class="container">

    <div class="mx-3">
        {{ Breadcrumbs::render('formSolucao', $tipoForm) }}
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
                <h4 class="card-title"> {{ isset($solucao) ? 'Editar Solução' : 'Adicionar Solução' }}</h4>
            </div>
        </div>
        <form id="formSolucao" action="{{ isset($solucao) ? route('solucoes.update', $solucao->id) : route('solucoes.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if(isset($solucao))
            @method('PUT')
            @endif

            <!-- Campo Nome do arquivo -->
            <div class="form-group mb-4">
                <label for="titulo" class="form-label">Título da soluçãos</label>
                <input
                    name="titulo"
                    type="text"
                    class="form-control"
                    id="titulo"
                    placeholder="Digite o título da solução"
                    value="{{ old('titulo', isset($solucao) ? $solucao->titulo : '') }}" />
            </div>

            <!-- Campo Descricao-->
            <div class="form-group mb-4">
                <label for="descricao" class="form-label">Descrição</label>
                <input
                    name="descricao"
                    type="text"
                    class="form-control"
                    id="descricao"
                    placeholder="Digite a descrição da solucão"
                    required
                    value="{{ old('descricao', isset($solucao) ? $solucao->descricao : '') }}" />
            </div>

            <!-- Campo Passos de Implementação da solução -->
            <div class="form-group mb-4">
                <label for="passosImplementacao" class="form-label">Passos de implementação</label>
                <textarea
                    name="passosImplementacao"
                    class="form-control"
                    id="passosImplementacao"
                    rows="10"
                    placeholder="Escreva os passos de implementação da solução"
                    required>{{ old('passosImplementacao', isset($solucao) ? $solucao->passosImplementacao : '') }}</textarea>
            </div>

            <!-- Públicos-Alvo -->
            <div class="form-group mb-4">
                <label for="publicos" class="form-label">Públicos-Alvo</label>
                <div class="row">
                    @foreach($publicosAlvo->chunk(ceil($publicosAlvo->count() / 2)) as $chunk)
                    <div class="col-md-6">
                        @foreach($chunk as $publico)
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="publicos_alvo[]"
                                value="{{ $publico->id }}"
                                id="publico_{{ $publico->id }}"
                                @if(isset($solucao) && $solucao->publicosAlvo->contains($publico->id)) checked @endif
                            >
                            <label class="form-check-label pl-4" for="publico_{{ $publico->id }}">
                                {{ $publico->nome }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Campo Categoria -->
            <div class="form-group mb-4">
                <label for="categoria" class="form-label">Categoria</label>
                <select name="idCategoria" class="form-select form-control" id="categoria" data-tipo="solucoes" required>
                    <option value="" disabled selected>Selecione uma categoria...</option>
                    @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        {{ isset($solucao) && $solucao->idCategoria == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nomeCategoria }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Upload de novo arquivo -->
            <div class="mb-3">
                <label for="arquivo" class="form-label px-3 fw-semibold">
                    {{ isset($solucao) ? 'Substituir o arquivo (Imagem ou PDF)' : 'Selecione um arquivo para upload se necessário' }}
                </label>
                <input class="form-control" type="file" id="arquivo" name="arquivo" accept=".pdf,.jpg,.jpeg,.png">
                <small class="form-text text-muted px-3">Você pode fazer o upload de arquivos PDF ou imagens (JPG, JPEG, PNG).</small>
            </div>

            <!-- Botões -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('solucoes.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">{{ isset($solucao) ? 'Atualizar Solução' : 'Salvar Solucão' }}</button>
            </div>
        </form>
    </div>
</div>

@endsection