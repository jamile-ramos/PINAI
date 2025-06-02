@extends('layouts.app')

@section('title', $nai->nome)

@section('content')

<!-- Card de Informações -->
<main class="container-fluid my-5">

    {{ Breadcrumbs::render('showNai', $nai) }}

    <div class="row justify-content-center">
        <div class="card shadow-lg p-4">
            <div class="card-body">
                <!-- Nome e Sigla -->
                <h4 class="card-title">
                    {{ $nai->nome }}
                    <small class="text-muted">({{ $nai->siglaNai }})</small>
                </h4>
                <hr>

                <div class="col mt-5">
                    <!-- Instituição -->
                    <p class="mt-3"><strong>Instituição:</strong> {{ $nai->instituicao }} ({{ $nai->siglaInstituicao }})</p>

                    <!-- Localização -->
                    <p class="mt-3"><strong>Estado:</strong> {{ $nai->estado }}</p>
                    <p class="mt-3"><strong>Cidade:</strong> {{ $nai->cidade }}</p>

                    <!-- Contato -->
                    <p class="mt-3"><strong>Email:</strong> <a href="mailto:{{ $nai->email }}">{{ $nai->email }}</a></p>
                    <p class="mt-3"><strong>Telefone:</strong> {{ $nai->telefone }}</p>

                    <!-- Site -->
                    <p class="mt-3"><strong>Site:</strong>
                        <a href="{{ $nai->site }}" target="_blank" rel="noopener">
                            {{ $nai->site }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection