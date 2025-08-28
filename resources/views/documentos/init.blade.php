@if(request()->filled('query') && $abaAtiva === 'visaoDocumentos')
<div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
    <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
        Foram encontrados {{ $documentos->total() }} resultado{{ $documentos->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
    </span>
    <a href="{{ route('documentos.index') }}?abaAtiva={{ request('abaAtiva') }}"
        class="btn-limpar-filtro"
        aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
        <i class="fas fa-times-circle" aria-hidden="true"></i>
        Limpar Filtro
    </a>
</div>

<div class="row g-4 mb-4">
    @foreach($documentos as $documento)
    <div class="col-md-4 col-sm-6">
        <div class="card h-100 shadow rounded-4 border-0">
            <div class="card-body text-center d-flex flex-column justify-content-between">
                <div class="mb-3">
                    <i class="fa fa-file-pdf fa-3x text-primary"></i>
                </div>
                <h3 class="fs-6 card-title fw-semibold">{{ $documento->nomeArquivo }}</h3>
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

<div class="d-flex justify-content-center mt-3">
    {{ $documentos->appends(request()->except('documentos_page'))->links('vendor.pagination.bootstrap-5') }}
</div>

@else

@foreach($categorias as $categoria)
@if($categoria->documentos->isNotEmpty())
<div class="row mb-4">
    <div class="col">
        <h2 class="fs-3 nomeCategoria fw-bold">
            <a href="{{ route('documentos.documentosCategorias', $categoria->id) }}" class="categoria d-inline-flex align-items-center gap-2">
                {{ $categoria->nomeCategoria }}
                <svg viewBox="0 0 32 32" focusable="false" aria-hidden="true" width="22" height="15" fill="currentColor">
                    <path d="M21.6 14.3L5.5 31h6.4l14.6-15L11.9 1H5.5l16.1 16.7v-3.4z"></path>
                </svg>
            </a>
        </h2>
    </div>
</div>

<div class="row g-4 mb-5 pb-2">
    @foreach($categoria->documentos as $documento)
    <div class="col-md-4 col-sm-6">
        <div class="card h-100 shadow rounded-4 border-0">
            <div class="card-body text-center d-flex flex-column justify-content-between">

                <i class="fa fa-file-alt fa-3x text-primary"></i>

                {{-- Nome e descrição --}}
                <h2 class="fs-5 card-title fw-semibold">{{ $documento->nomeArquivo }}</h2>
                <p class="card-text text-muted small">{{ Str::limit($documento->descricao, 150) }}</p>

                {{-- Se for arquivo PDF/Word/etc e link --}}
                @if($documento->caminhoArquivo && $documento->link)
                <a href="{{ $documento->link }}"
                    target="_blank" class="btn btn-link text-wrap">
                    <i class="fa fa-external-link-alt"></i> Acessar Link
                </a>
                <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}"
                    target="_blank" class="btn btn-primary text-wrap mb-2">
                    <i class="fa fa-eye"></i> Visualizar Arquivo
                </a>
                {{-- Se for link externo --}}
                @elseif ($documento->link)
                <a href="{{ $documento->link }}"
                    target="_blank" class="btn btn-link text-wrap">
                    <i class="fa fa-external-link-alt"></i> Acessar Link
                </a>
                {{-- Se for só documento --}}
                @else
                <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}"
                    target="_blank" class="btn btn-primary text-wrap mb-2">
                    <i class="fa fa-eye"></i> Visualizar Arquivo
                </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endforeach

<!-- Paginação -->
<div class="d-flex justify-content-center mt-3">
    {{ $categorias->appends(request()->except('visaoCategoriasDoc_page'))->links('vendor.pagination.bootstrap-5') }}
</div>

@endif