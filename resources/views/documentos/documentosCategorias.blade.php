@extends('layouts.app')

@section('title', $categoria->nomeCategoria)

@section('content')

<div class="container py-2">

    <div class="mb-4">
        {{ Breadcrumbs::render('categoriaDocumento', $categoria)}}
    </div>

    <div class="my-4 mb-0 pb-4">
        <h1 class="h2 fw-bolder text-uppercase text-dark mb-0 position-relative">
            <i class="fas fa-folder me-3 text-primary"></i>
            {{ $categoria->nomeCategoria }}
        </h1>
    </div>

    <div class="row g-4 mb-4">
        @foreach($documentos as $documento)
        <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow rounded-4 border-0">
                <div class="card-body text-center d-flex flex-column justify-content-between">

                    <i class="fa fa-file-alt fa-3x text-primary"></i>

                    {{-- Nome e descrição --}}
                    <h2 class="fs-5 card-title fw-semibold">{{ $documento->nomeArquivo }}</h2>
                    <p class="card-text text-muted small">{{ Str::limit($documento->descricao, 150) }}</p>

                    {{-- Se for arquivo PDF/Word/etc e link --}}
                    @if($documento->caminhoArquivo && $documento->link)
                    <a href="{{ $documento->link }}"
                        target="_blank" class="btn btn-link text-wrap">
                        <i class="fa fa-external-link-alt"></i> Acessar Link
                    </a>
                    <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}"
                        target="_blank" class="btn btn-primary text-wrap mb-2">
                        <i class="fa fa-eye"></i> Visualizar Arquivo
                    </a>
                    {{-- Se for link externo --}}
                    @elseif ($documento->link)
                    <a href="{{ $documento->link }}"
                        target="_blank" class="btn btn-link text-wrap">
                        <i class="fa fa-external-link-alt"></i> Acessar Link
                    </a>
                    {{-- Se for só documento --}}
                    @else
                    <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}"
                        target="_blank" class="btn btn-primary text-wrap mb-2">
                        <i class="fa fa-eye"></i> Visualizar Arquivo
                    </a>
                    @endif

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection