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
                    <h4 class="card-title"> {{ isset($noticia) ? 'Editar Núcleo de Acessibilidade e Inclusão' : 'Adicionar Núcleo de Acessibilidade e Inclusão' }}</h4>
                </div>
            </div>
            <form id="formNoticia" action="{{ isset($nai) ? route('nais.update', $nai->id) : route('nais.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($noticia))
                @method('PUT')
                @endif

                <div class="row mx-0">
                    <!-- Campo Nome do NAI -->
                    <div class="form-group col-md-8 mb-4">
                        <label for="nome" class="form-label">Nome</label>
                        <input
                            name="nome"
                            type="text"
                            class="form-control"
                            id="nome"
                            placeholder="Núcleo de Atendimento às Pessoas com necessidades Específicas"
                            required
                            value="{{ old('nome', isset($noticia) ? $noticia->titulo : '') }}" />
                    </div>

                    <!-- Campo Sigla do NAI -->
                    <div class="form-group col-md-4 mb-4">
                        <label for="siglaNai" class="form-label">Sigla do Núcleo (NAI)</label>
                        <input
                            name="siglaNai"
                            type="text"
                            class="form-control"
                            id="siglaNai"
                            placeholder="Ex: NAPNE"
                            required
                            value="{{ old('siglaNai', isset($noticia) ? $noticia->siglaNai : '') }}" />
                    </div>
                </div>

                <div class="row mx-0">
                    <!-- Campo Instituição-->
                <div class="form-group col-md-8 mb-4">
                    <label for="instituicao" class="form-label">Nome completo da instituição</label>
                    <input
                        name="instituicao"
                        type="text"
                        class="form-control"
                        id="instituicao"
                        placeholder="Ex: Instituto Federal de Educação, Ciência e Tecnologia Baiano - Campus Guanambi"
                        required
                        value="{{ old('instituicao', isset($noticia) ? $noticia->instituicao : '') }}" />
                </div>

                <!-- Campo sigla da Instituicao -->
                <div class="form-group col-md-4 mb-4">
                    <label for="siglaInstituicao" class="form-label">Sigla da Intituição</label>
                    <input
                        name="siglaInstituicao"
                        type="text"
                        class="form-control"
                        id="siglaInstituicao"
                        placeholder="Ex: If Baiano Guanambi"
                        required
                        value="{{ old('siglaInstituicao', isset($noticia) ? $noticia->siglaInstituicao : '') }}" />
                </div>
                </div>

                <div class="row mx-0">
                    <!-- Campo Estados brasileiros -->
                    <div class="form-group col-md-6 mb-4">
                        <label for="estados" class="form-label">Estado</label>
                        <select name="idEstado" class="form-select form-control" id="estado" data-tipo="estado" required>
                            <option value="" disabled selected>Selecione um estado...</option>
                        </select>
                    </div>

                    <!-- Campo Cidades -->
                    <div class="form-group col-md-6 mb-4">
                        <label for="cidades" class="form-label">Cidade</label>
                        <select name="idCidade" class="form-select form-control" id="cidade" data-tipo="cidade" required>
                            <option value="" disabled selected>Selecione a cidade...</option>
                        </select>
                    </div>
                </div>

                <div class="row mx-0">
                    <!-- Campo email do Nai -->
                    <div class="form-group col-md-4 mb-4">
                        <label for="email" class="form-label">E-mail:</label>
                        <input
                            name="email"
                            type="email"
                            class="form-control"
                            id="email"
                            placeholder="Digite o e-mail"
                            required
                            value="{{ old('email', isset($noticia) ? $noticia->email : '') }}" />
                    </div>

                    <!-- Campo telefone -->
                    <div class="form-group col-md-4 mb-4">
                        <label for="email" class="form-label">Telefone:</label>
                        <input
                            name="telefone"
                            type="phone"
                            class="form-control"
                            id="telefone"
                            placeholder="Digite o telefone"
                            required
                            value="{{ old('telefone', isset($noticia) ? $noticia->telefone : '') }}" />
                    </div>

                    <!-- Campo telefone -->
                    <div class="form-group col-md-4 mb-4">
                        <label for="site" class="form-label">Site:</label>
                        <input
                            name="site"
                            type="text"
                            class="form-control"
                            id="site"
                            placeholder="Digite o site do NAI"
                            value="{{ old('site', isset($noticia) ? $noticia->site : '') }}" />
                    </div>
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