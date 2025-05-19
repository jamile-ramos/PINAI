@extends('layouts.app')

@section('title', $categoria->nomeCategoria)

@section('content')

<div class="container py-2">

    <div class="row mb-4">
        <div class="col">
            <h2 class="nomeCategoria fw-bold">{{ $categoria->nomeCategoria }}</h2>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach($solucoes as $solucao)
        <div class="col">
          <div class="card h-100 border-0 shadow-lg rounded-4">
            <div class="card-body d-flex flex-column p-4">
              <h5 class="card-title text-primary fw-bold mb-3">{{ $solucao->titulo }}</h5>
              <p class="text-secondary mb-4"><strong>Por:</strong> NAi</p>  <!-- Nome do NAI -->
              <p class="card-text text-muted mb-4">{{ Str::limit($solucao->descricao, 120) }}</p>
              <div class="d-flex justify-content-between mt-auto">
                <div class="text-secondary">
                  <strong>Público-Alvo:</strong>
                  <ul class="list-unstyled mb-3">
                    @foreach($solucao->publicosAlvo as $publico)
                    <li>• {{ $publico->nome }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
              <a href="{{ route('solucoes.show', $solucao->id) }}" class="btn btn-primary rounded-pill px-4 py-2 mt-2">
                Ver mais
              </a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
</div>
@endsection