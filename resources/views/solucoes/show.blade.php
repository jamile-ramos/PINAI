@extends('layouts.app')

@section('title', 'Detalhes da Solução')

@section('content')
<div class="container py-3">

    {{ Breadcrumbs::render('verSolucao', $solucao) }}

    <div class="card shadow-lg border-0 rounded-4 p-5 bg-white">

        <!-- Título, Categoria e Descrição -->
        <div class="mb-4 text-center">
            <h1 class="h3 fw-bold text-primary">{{ $solucao->titulo }}</h1>
            <p class="mb-3 mt-5">
                <span class="visually-hidden">Categoria da solução:</span>
                <span class="badge bg-primary fs-6" role="status" aria-label="Categoria: {{ $solucao->categoria->nomeCategoria }}">
                    <i class="fas fa-tag me-1" aria-hidden="true"></i>
                    {{ $solucao->categoria->nomeCategoria }}
                </span>
            <p>

            <p class="text-muted fs-5 mt-3" style="text-align: justify;">
                {{ $solucao->descricao }}
            </p>
        </div>

        <!-- Público-Alvo -->
        <div class="mb-5 p-4 bg-light rounded-4 shadow-sm">
            <h2 class="fs-5 text-primary mb-3 d-flex align-items-center fw-bold">
                <i class="fas fa-users me-2 fs-5 pr-2"></i>
                Público-Alvo
            </h2>
            <ul class="ps-3 mb-0 text-muted publico-alvo-list">
                @forelse($solucao->publicosAlvo as $publico)
                <li>{{ $publico->nome }}</li>
                @empty
                <li><em>Nenhum público-alvo especificado</em></li>
                @endforelse
            </ul>
        </div>

        <!-- Passos de Implementação -->
        <div class="bg-light p-4 rounded-4 shadow-sm mb-3">
            <h2 class="fs-5 text-primary mb-3 d-flex align-items-center fw-bold">
                <i class="fas fa-clipboard-list me-2 fs-5 pr-2"></i>
                Passos para Implementação
            </h2>
            <p class="text-muted" style="text-align: justify;">
                {!! $solucao->passosImplementacao !!}
            </p>
        </div>

        <!-- Arquivo (opcional) -->
        <div class="mt-5">
            <h2 class="fs-5text-primary mb-3 d-flex align-items-center fw-bold"><i class="bi bi-paperclip me-2"></i>Material Complementar</h2>
            @if($solucao->arquivo)
            @php
            $extensao = pathinfo($solucao->arquivo, PATHINFO_EXTENSION);
            @endphp

            @if(in_array($extensao, ['jpg', 'jpeg', 'png', 'gif']))
            <!-- Exibindo Imagem -->
            <div class="noticia-imagem">
                <img src="{{ asset('storage/'.$solucao->arquivo) }}" alt="Arquivo Imagem" class="img-fluid">
            </div>
            @elseif($extensao == 'pdf')
            <!-- Exibindo PDF -->
            <embed src="{{ asset('storage/'.$solucao->arquivo) }}" type="application/pdf" width="100%" height="500px">
            @else
            <!-- Link para outros tipos de arquivo -->
            <a href="{{ asset('storage/'.$solucao->arquivo) }}" class="text-decoration-underline" target="_blank">{{ $solucao->arquivo }}</a>
            @endif
            @else
            <p>Nenhum arquivo anexado.</p>
            @endif
        </div>

    </div>

    <section class="highlighted-solutions w-100">
      <div class="d-flex align-items-center mb-4">
        <h2 class="h3 fw-bolder mb-0 pb-0">Explore Outras Soluções</h2>
      </div>

      <div class="row g-4">
        @foreach($ultimasSolucoes as $solucao)
        <div class="col-12 col-md-6 col-lg-4">
          <a href="{{ route('solucoes.show', ['id' => $solucao->id, 'slug' => $solucao->slug]) }}"
            class="card h-100 text-decoration-none border-0 shadow-sm rounded-3 solution-card"
            aria-label="Abrir solução: {{ $solucao->titulo }}">

            <div class="card-body d-flex flex-column solutions">
              <div class="text-center mb-3">
                <i class="fas fa-lightbulb fa-2x text-primary"></i>
              </div>
              <h3 class="h6 fw-bold text-dark mb-2 text-truncate">
                {{ $solucao->titulo }}
              </h3>
              <p class="text-muted small flex-grow-1">
                {{ Str::limit($solucao->descricao, 100) }}
              </p>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                  <i class="fas fa-universal-access me-1"></i> {{ $solucao->user->nai->siglaNai }}
                </small>
                <small class="text-muted">
                  <i class="fas fa-calendar-alt me-1"></i> {{ $solucao->created_at->format('d/m/Y') }}
                </small>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </section>
</div>
@endsection