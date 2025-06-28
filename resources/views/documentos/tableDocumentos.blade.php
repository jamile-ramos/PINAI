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
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-info btn-edit"
                            data-url="{{ route('documentos.edit', $documento->id) }}"
                            data-original-title="Editar"
                            aria-label="Editar notícia">
                            Editar
                        </button>
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-danger btn-remove"
                            data-original-title="Excluir"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('documentos.destroy')}}"
                            data-id="{{ $documento->id }}"
                            title="Excluir"
                            aria-label="Excluir notícia">
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