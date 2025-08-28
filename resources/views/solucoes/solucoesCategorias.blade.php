@extends('layouts.app')

@section('title', $categoria->nomeCategoria)

@section('content')

<div class="container py-2">

  {{ Breadcrumbs::render('categoriaSolucao', $categoria)}}

  <div class="my-4 mb-0 pb-4">
    <h1 class="h2 fw-bolder text-uppercase text-dark mb-0 position-relative">
      <i class="fas fa-folder me-3 text-primary"></i>
      {{ $categoria->nomeCategoria }}
    </h1>
  </div>

  <div class="row row-cols-1 row-cols-md-2 g-4">
    @foreach($solucoes as $solucao)
    <div class="col">
      <div class="card h-100 border-0 shadow-lg rounded-4">
        <div class="card-body d-flex flex-column p-4">
          <h2 class="fs-5 card-title text-primary fw-bold mb-3">{{ $solucao->titulo }}</h2>
          <p class="text-secondary mb-4"><strong>Por:</strong> NAi</p> <!-- Nome do NAI -->
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
          <a href="{{ route('solucoes.show', ['id' => $solucao->id, 'slug' => $solucao->slug]) }}" class="btn btn-primary rounded-pill px-4 py-2 mt-2">
            Ver mais
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection