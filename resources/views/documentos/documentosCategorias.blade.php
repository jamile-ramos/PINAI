@extends('layouts.app')

@section('title', $categoria->nomeCategoria)

@section('content')

<div class="container py-2">

    <div class="mb-4">
        {{ Breadcrumbs::render('categoriaDocumento', $categoria)}}
    </div>

    <div class="row mb-4">
        <div class="col">
            <h2 class="nomeCategoria fw-bold">{{ $categoria->nomeCategoria }}</h2>
        </div>
    </div>

    <div class="row g-4 mb-4">
        @foreach($documentos as $documento)
        <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow rounded-4 border-0">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <div class="mb-3">
                        <i class="fa fa-file-pdf fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-semibold">{{ $documento->titulo }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($documento->descricao, 100) }}</p>
                    <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}" target="_blank" class="btn btn-link text-wrap">
                        <i class="fa fa-eye"></i> Visualizar
                    </a>
                    <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}" download class="btn btn-primary text-wrap">
                        <i class="fa fa-download"></i> Download
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection