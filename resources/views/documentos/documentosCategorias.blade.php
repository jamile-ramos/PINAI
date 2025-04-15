@extends('layouts.app')

@section('title', $categoria->nomeCategoria)

@section('content')

<div class="container py-2">

    <div class="row mb-4">
        <div class="col">
            <h2 class="nomeCategoria fw-bold">{{ $categoria->nomeCategoria }}</h2>
        </div>
    </div>

    <div class="row g-4">
        @foreach($documentos as $documento)
        <div class="col-md-4 col-sm-6 mb-5">
            <div class="card h-100 shadow-sm p-4">
                <div class="mb-3 d-flex justify-content-center">
                    <i class="fa fa-file-pdf fa-3x text-primary"></i>
                </div>
                <div class="card-body d-flex flex-column text-center">
                    <h5 class="card-title py-3">{{ $documento->nomeArquivo }}</h5>
                    <p class="card-text text-muted">{{ $documento->descricao }}</p>
                    <div class="mt-auto d-flex justify-content-between">
                        <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}" target="_blank" class="btn btn-link text-wrap">
                            <i class="fa fa-eye"></i> Visualizar
                        </a>
                        <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}" download class="btn btn-primary text-wrap">
                            <i class="fa fa-download"></i> Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection