<div class="table-responsive">
    @if(request()->filled('query') && $abaAtiva === $tipoAba)
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
    @endif

    {{-- Cards desktop --}}
    <div class="d-none d-md-block">
    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th>Nome do arquivo</th>
                <th>Categoria</th>
                @if($tipoAba === 'allDocumentos')
                <th>Autor</th>
                @endif
                <th>Data de Criação</th>
                <th style="width: 10%">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentos as $documento)
            <tr>
                <td class="fw-bold">{{ $documento->nomeArquivo }}</td>
                <td class="text-start">
                    {{ $documento->categoria_documento->nomeCategoria }}
                </td>
                @if($tipoAba === 'allDocumentos')
                <td class="text-start">
                    {{ $documento->user->name }}
                </td>
                @endif
                <td class="text-start">
                    {{ $documento->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <div class="form-button-action">
                        <a class="btn btn-visualizar" href="{{ asset('storage/' . $documento->caminhoArquivo) }}" aria-label="Visualizar documento">
                            Visualizar
                        </a>
                        @if(Auth::user()->tipoUsuario != 'comum' || (Auth::user()->id == $documento->idUsuario && $tipoAba == 'myDocumentos'))
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-primary btn-edit"
                            data-url="{{ route('documentos.edit', $documento->id) }}"
                            data-original-title="Editar"
                            aria-label="Editar notícia">
                            Editar
                        </button>
                        @endif
                        <button type="button"
                            class="btn btn-danger btn-remove"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmExcluirModal"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Excluir"
                            aria-label="Excluir notícia"
                            data-url="{{ route('documentos.destroy', $documento->id ) }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Nenhum documento encontrado!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    {{-- Cards mobile --}}
    <div class="d-block d-md-none">
        @forelse($documentos as $documento)
        <div class="card mb-3 shadow-md">
            <div class="card-body">
                <h5 class="card-title fw-bold mt-0 border-bottom border-secondary pb-2">{{ $documento->nomeArquivo }}</h5>
                <div class="mb-2 border-bottom border-light pb-2 pt-2">
                    <p class="mb-2"><i class="fas fa-folder text-primary me-1" aria-hidden="true"></i> {{ $documento->categoria_documento->nomeCategoria }}</p>

                    @if($tipoAba === 'allDocumentos')
                    <p class="mb-2"><i class="fas fa-user text-primary me-1" aria-hidden="true"></i> {{ $documento->user->name }}</p>
                    @endif

                    <p class="mb-2 text-muted"><i class="fas fa-calendar-alt text-primary me-1" aria-hidden="true"></i> Adicionado em: {{ $documento->created_at->format('d/m/Y') }}</p>

                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a class="btn btn-md btn-visualizar flex-fill text-center" href="{{ asset('storage/' . $documento->caminhoArquivo) }}" target="_blank">
                        Visualizar
                    </a>
                    @if(Auth::user()->tipoUsuario != 'comum' || (Auth::user()->id == $documento->idUsuario && $tipoAba == 'myDocumentos'))
                    <a class="btn btn-md btn-primary flex-fill text-center" href="{{ route('documentos.edit', $documento->id) }}">
                        Editar
                    </a>
                    @endif
                    <button class="btn btn-md btn-danger btn-remove flex-fill text-center"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmExcluirModal"
                        data-url="{{ route('documentos.destroy', $documento->id) }}">
                        Excluir
                    </button>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-muted">Nenhum documento encontrado!</p>
        @endforelse

        {{-- Paginação --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $documentos->appends(request()->except($tipoAba.'_page'))->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

</div>

<!-- Paginação -->
<div class="d-flex justify-content-center mt-3">
    {{ $documentos->appends(request()->except($tipoAba.'_page'))->links('vendor.pagination.bootstrap-5') }}
</div>