@foreach($categorias as $categoria)
@php
$documentosCategoria = $categoria->documentos()->where('status', 'ativo')->latest()->take(3)->get();
@endphp

@if($documentosCategoria->isNotEmpty())
<div class="row mb-4">
    <div class="col">
        <p class="h3 nomeCategoria fw-bold">
            <a href="{{ route('documentos.documentosCategorias', $categoria->id) }}" class="categoria d-inline-flex align-items-center gap-2">
                {{ $categoria->nomeCategoria }}
                <svg viewBox="0 0 32 32" focusable="false" aria-hidden="true" width="22" height="15" fill="currentColor">
                    <path d="M21.6 14.3L5.5 31h6.4l14.6-15L11.9 1H5.5l16.1 16.7v-3.4z"></path>
                </svg>
            </a>
        </p>
    </div>
</div>

<div class="row g-4 mb-4">
    @foreach($documentosCategoria as $documento)
    <div class="col-md-4 col-sm-6">
        <div class="card h-100 shadow rounded-4 border-0">
            <div class="card-body text-center d-flex flex-column justify-content-between">
                <div class="mb-3">
                    <i class="fa fa-file-pdf fa-3x text-primary"></i>
                </div>
                <h5 class="card-title fw-semibold">{{ $documento->titulo }}</h5>
                <p class="card-text text-muted small">{{ Str::limit($documento->descricao, 100) }}</p>
                <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}" target="_blank" class="btn btn-link text-wrap">
                    <i class="fa fa-eye"></i> Visualizar
                </a>
                <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}" download class="btn btn-primary text-wrap">
                    <i class="fa fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endforeach