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
            <h5 class="text-primary mb-3 d-flex align-items-center fw-bold">
                <i class="fas fa-users me-2 fs-5 pr-2"></i>
                Público-Alvo
            </h5>
            <ul class="ps-3 mb-0 text-secondary publico-alvo-list">
                @forelse($solucao->publicosAlvo as $publico)
                <li>{{ $publico->nome }}</li>
                @empty
                <li><em>Nenhum público-alvo especificado</em></li>
                @endforelse
            </ul>
        </div>

        <!-- Passos de Implementação -->
        <div class="bg-light p-4 rounded-4 shadow-sm mb-3">
            <h5 class="text-primary mb-3 d-flex align-items-center fw-bold">
                <i class="fas fa-clipboard-list me-2 fs-5 pr-2"></i>
                Passos para Implementação
            </h5>
            <p class="text-secondary" style="text-align: justify;">
                {!! nl2br(e($solucao->passosImplementacao)) !!}
            </p>
        </div>

        <!-- Arquivo (opcional) -->
        <div class="mt-5">
            <h5 class="text-primary mb-3 d-flex align-items-center fw-bold"><i class="bi bi-paperclip me-2"></i>Material Complementar</h5>
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
</div>
@endsection