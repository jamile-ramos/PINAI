@extends('layouts.app')

@section('title', isset($resposta) ? 'Editar Resposta' : 'Adicionar Resposta')

@section('content')
<div class="container my-5">
    <div class="card border-0 shadow rounded-4">

        <!-- Informações da postagem -->
        <div class="p-4 border-bottom bg-white">
            <span class="badge bg-primary text-white fw-bold fs-6 px-3 py-2 mb-3">
                {{ $postagem->topico->titulo }}
            </span>

            <h5 class="fw-bold mb-3">📌 {{ $postagem->titulo }}</h5>

            <div class="border rounded p-3">
                <p class="mb-0 text-muted">{{ $postagem->conteudo }}</p>
            </div>
        </div>

        <!-- Formulário de resposta -->
        <div class="p-4 bg-light">
            <form action="{{ isset($resposta) ? route('respostas.update', $resposta->id) : route('respostas.store', $postagem->id) }}" method="POST">
                @csrf
                @if(isset($resposta))
                @method('PUT')
                @endif
                <div class="mb-3">
                    <label for="conteudo" class="form-label fw-semibold">Sua Resposta</label>
                    @php
                    $conteudo = old('conteudo', isset($resposta) ? $resposta->conteudo : '');
                    @endphp

                    <textarea name="conteudo" id="conteudo" class="form-control shadow-sm rounded-3" rows="6" placeholder="Compartilhe sua resposta ou opinião..." required>{{ $conteudo }}</textarea>

                    </textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back();" aria-label="Cancelar resposta">Cancelar</button>
                    <button type="submit" class="btn btn-primary" aria-label="Publicar resposta">{{ isset($resposta) ? 'Salvar alteração' : 'Publicar Resposta'}}</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection