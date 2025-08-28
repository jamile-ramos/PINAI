@extends('layouts.app')

@section('title', $nai->nome)

@section('content')

<!-- Card de Informações -->
<main class="container-fluid">

    {{ Breadcrumbs::render('showNai', $nai) }}

    <div class="row justify-content-center mt-5">
        <div class="card shadow-lg p-4">
            <div class="card-body">
                <!-- Nome e Sigla -->
                <h1 class=" fs-3 card-title mb-2">
                    {{ $nai->nome }}
                    <small class="text-muted">({{ $nai->siglaNai }})</small>
                </h1>
                <hr>

                <div class="col mt-4">
                    <!-- Instituição -->
                    <p class="mt-3"> <i class="fas fa-building me-2 text-primary" aria-hidden="true"></i><strong>Instituição:</strong> {{ $nai->instituicao }} ({{ $nai->siglaInstituicao }})</p>

                    <!-- Localização -->
                    <p class="mt-3"><i class="fas fa-map-marker-alt me-2 text-primary" aria-hidden="true"></i><strong>Estado:</strong> {{ $nai->estado }}</p>
                    <p class="mt-3"><i class="fas fa-city me-2 text-primary" aria-hidden="true"></i><strong>Cidade:</strong> {{ $nai->cidade }}</p>

                    <!-- Contato -->
                    <p class="mt-3"><i class="fas fa-envelope me-2 text-primary" aria-hidden="true"></i><strong>Email:</strong> <a href="mailto:{{ $nai->email }}">{{ $nai->email }}</a></p>
                    <p class="mt-3"><i class="fas fa-phone me-2 text-primary" aria-hidden="true"></i><strong>Telefone:</strong>
                        <a href="tel:{{ $nai->telefone }}">{{ $nai->telefone }}</a>
                    </p>

                    <!-- Site -->
                    <p class="mt-3"><i class="fas fa-globe me-2 text-primary" aria-hidden="true"></i><strong>Site:</strong>
                        <a href="{{ $nai->site }}" target="_blank" rel="noopener" aria-labelledby="site-link-label">
                            {{ $nai->site }}
                        </a>
                        <span id="site-link-label" class="visually-hidden">Visitar o site do {{ $nai->nome }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection