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
        @foreach($solucoes as $solucao)
        <div class="mb-4">
            <div class="card shadow-lg rounded-4 border-0 p-4">
                <div class="card-body p-4">
                    <h4 class="card-title fw-semibold text-dark mb-3">{{ $solucao->titulo }}</h4>

                    <p class="card-text text-muted mb-4">
                        {{ $solucao->descricao }}
                    </p>

                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <strong class="text-secondary d-block">Público-Alvo:</strong>
                            <ul>
                                @foreach($solucao->publicosAlvo as $publico)
                                <li>• {{ $publico->nome }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <strong class="text-secondary d-block">Categoria:</strong>
                            <span>{{ $solucao->categoria->nomeCategoria }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Por NAI IFSP</small>
                        <a href="{{ route('solucoes.show', $solucao->id) }}" class="btn btn-primary rounded-pill px-4">Ver Mais</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection