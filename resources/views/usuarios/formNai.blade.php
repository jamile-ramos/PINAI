@extends('layouts.app')

@section('title', isset($nai) ? 'Editar Núcleo de Acessibilidade e Inclusão' : 'Adicionar Núcleo de Acessibilidade e Inclusão')

@section('content')

<div class="col">
    <div class="mx-4">
        @php
        $tipoForm =isset($nai) ? 'Editar Núcleo de Acessibilidade e Inclusão' : 'Adicionar Núcleo de Acessibilidade e Inclusão'
        @endphp
        {{ Breadcrumbs::render('formNai', $tipoForm)}}
    </div>

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mt-2 mx-3 rounded" role="alert">
        <strong>Foram encontrados {{ $errors->count() }} erro(s) no formulário.</strong>
        Verifique os campos destacados abaixo.
        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
    @endif


    <div class="container my-5">
        <div class="card shadow-lg p-4">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h1 class="fs-4 card-title"> {{ isset($nai) ? 'Editar Núcleo de Acessibilidade e Inclusão' : 'Adicionar Núcleo de Acessibilidade e Inclusão' }}</h1>
                </div>
            </div>
            <form id="formnai" action="{{ isset($nai) ? route('nais.update', $nai->id) : route('nais.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($nai))
                @method('PUT')
                @endif

                <div class="row mx-0">
                    <!-- Campo Nome do NAI -->
                    <div class="form-group col-md-8 mb-4">
                        <label for="nome" class="form-label fw-bold">Nome <span class="text-danger">*</span></label>
                        <input
                            name="nome"
                            type="text"
                            class="form-control @error('nome') is-invalid @enderror"
                            aria-describedby="@error('nome') error-nome @enderror"
                            id="nome"
                            placeholder="Núcleo de Atendimento às Pessoas com necessidades Específicas"
                            required
                            value="{{ old('nome', isset($nai) ? $nai->nome : '') }}" />

                        {{-- Mensagem de erro ligada ao aria-describedby --}}
                        @error('nome')
                        <div id="error-nome" class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Campo Sigla do NAI -->
                    <div class="form-group col-md-4 mb-4">
                        <label for="siglaNai" class="form-label fw-bold">Sigla do Núcleo (NAI) <span class="text-danger">*</span></label>
                        <input
                            name="siglaNai"
                            type="text"
                            class="form-control @error('siglaNai') is-invalid @enderror"
                            aria-describedby="@error('siglaNai') error-siglaNai @enderror"
                            id="siglaNai"
                            placeholder="Ex: NAPNE"
                            required
                            value="{{ old('siglaNai', isset($nai) ? $nai->siglaNai : '') }}" />

                        @error('siglaNai')
                        <div id="error-siglaNai" class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row mx-0">
                    <!-- Campo Instituição-->
                    <div class="form-group col-md-8 mb-4">
                        <label for="instituicao" class="form-label fw-bold">Nome completo da instituição <span class="text-danger">*</span></label>
                        <input
                            name="instituicao"
                            type="text"
                            class="form-control @error('instituicao') is-invalid @enderror"
                            aria-describedby="@error('instituicao') error-instituicao @enderror"
                            id="instituicao"
                            placeholder="Ex: Instituto Federal de Educação, Ciência e Tecnologia Baiano - Campus Guanambi"
                            required
                            value="{{ old('instituicao', isset($nai) ? $nai->instituicao : '') }}" />
                        @error('instituicao')
                        <div id="error-instituicao" class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Campo sigla da Instituicao -->
                    <div class="form-group col-md-4 mb-4">
                        <label for="siglaInstituicao" class="form-label fw-bold">Sigla da Intituição <span class="text-danger">*</span></label>
                        <input
                            name="siglaInstituicao"
                            type="text"
                            class="form-control @error('siglaInstituicao') is-invalid @enderror"
                            aria-describedby="@error('siglaInstituicao') error-siglaInstituicao @enderror"
                            id="siglaInstituicao"
                            placeholder="Ex: If Baiano Guanambi"
                            required
                            value="{{ old('siglaInstituicao', isset($nai) ? $nai->siglaInstituicao : '') }}" />
                        @error('siglaInstituicao')
                        <div id="error-siglaInstituicao" class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row mx-0">
                    <!-- Campo Estados brasileiros -->
                    <div class="form-group col-md-6 mb-4">
                        <label for="estado" class="form-label fw-bold">Estado <span class="text-danger">*</span></label>
                        <select name="estado" class="form-select form-control" id="estado" data-tipo="estado" data-estado="{{ isset($nai) ? $nai->estado : '' }}" required>
                            <option value="" disabled selected>Selecione um estado...</option>
                        </select>
                    </div>

                    <!-- Campo Cidades -->
                    <div class="form-group col-md-6 mb-4">
                        <label for="cidade" class="form-label fw-bold">Cidade <span class="text-danger">*</span></label>
                        <select name="cidade" class="form-select form-control" id="cidade" data-tipo="cidade" data-cidade="{{ isset($nai) ? $nai->cidade : '' }}" required>
                            <option value="" disabled selected>Selecione a cidade...</option>
                        </select>
                    </div>
                </div>

                <div class="row mx-0">
                    <!-- Campo email do Nai -->
                    <div class="form-group col-md-4 mb-4">
                        <label for="email" class="form-label fw-bold">E-mail: <span class="text-danger">*</span></label>
                        <input
                            name="email"
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            aria-describedby="@error('email') error-email @enderror"
                            id="email"
                            placeholder="Digite o e-mail"
                            required
                            value="{{ old('email', isset($nai) ? $nai->email : '') }}" />
                        @error('email')
                        <div id="error-email" class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Campo telefone -->
                    <div class="form-group col-md-4 mb-4">
                        <label for="telefone" class="form-label fw-bold">Telefone:</label>
                        <input
                            name="telefone"
                            type="tel"
                            pattern="\(\d{2}\) \d{4,5}-\d{4}"
                            class="form-control @error('telefone') is-invalid @enderror"
                            aria-describedby="@error('telefone') error-telefone @enderror"
                            id="telefone"
                            placeholder="Ex: (21) 91234-5678"
                            value="{{ old('telefone', isset($nai) ? $nai->telefone : '') }}" />
                        @error('telefone')
                        <div id="error-telefone" class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Campo Site -->
                    <div class="form-group col-md-4 mb-4">
                        <label for="site" class="form-label fw-bold">Site:</label>
                        <input
                            name="site"
                            type="url"
                            class="form-control @error('site') is-invalid @enderror"
                            aria-describedby="@error('site') error-site @enderror"
                            id="site"
                            placeholder="Digite o site do NAI"
                            value="{{ old('site', isset($nai) ? $nai->site : '') }}" />
                        @error('site')
                        <div id="error-site" class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Botões -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('painel.usuarios') }}" class="btn btn-secondary" aria-label="Cancelar e voltar para o painel de usuários">Cancelar</a>
                    <button type="submit" class="btn btn-primary">{{ isset($nai) ? 'Atualizar NAI' : 'Salvar NAI' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection