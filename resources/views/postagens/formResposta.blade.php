@extends('layouts.app')

@section('title', isset($resposta) ? 'Editar Resposta' : 'Adicionar Resposta')

@php
$tipoForm = isset($resposta) ? 'Editar Resposta' : 'Adicionar Resposta';
@endphp

@section('content')
<div class="container my-5">

    {{Breadcrumbs::render('addResposta', $postagem, $tipoForm) }}
    <div class="card border-0 shadow rounded-4">

        <!-- Informações da postagem -->
        <div class="p-4 border-bottom bg-white">
            <span class="badge bg-primary text-white fw-bold fs-6 px-3 py-2 mb-3 text-truncate d-inline-block"
                style="max-width: 100%;"
                title="{{ $postagem->topico->titulo }}">
                {{ $postagem->topico->titulo }}
            </span>


            <h5 class="fw-bold mb-3">📌 {{ $postagem->titulo }}</h5>

            <div class="row border rounded p-2 mb-3 m-3 g-3">

                <!-- Texto resumido da postagem -->
                <div class="col-12 col-md-9 d-flex flex-column">
                    {!! nl2br(e(Str::limit($postagem->conteudo, 500))) !!}
                    @if(strlen($postagem->conteudo) > 500)
                    <div class="mt-3 mb-3">
                        <a href="{{ route('postagens.show', $postagem->topico->id) }}" class="text-primary">Ver postagem completa</a>
                    </div>
                    @endif
                </div>

                <!-- Miniatura da imagem -->
                @if($postagem->imagem)
                <div class="col-12 col-md-3 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('img/imgPostagens/' . $postagem->imagem) }}"
                        alt="Imagem da postagem"
                        class="img-thumbnail img-miniatura"
                        data-bs-toggle="modal"
                        data-bs-target="#imagemModal">
                </div>
                @endif

                <!-- Modal para ampliar imagem -->
                @if($postagem->imagem)
                <div class="modal fade" id="imagemModal" tabindex="-1" aria-labelledby="imagemModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imagemModalLabel">Imagem da Postagem</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ asset('img/imgPostagens/' . $postagem->imagem) }}"
                                    alt="Imagem da postagem"
                                    class="img-fluid"
                                    style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>
                </div>
                @endif

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