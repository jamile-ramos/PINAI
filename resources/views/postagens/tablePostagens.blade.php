<div class="table-responsive">
    @if(request()->filled('query') && $abaAtiva == $tipoAba)
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $postagens->total() }} resultado{{ $postagens->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('postagens.index', ['idTopico' => $topico->id]) }}?abaAtiva={{ request('abaAtiva') }}"
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
                <th>Título da postagem</th>
                @if($tipoAba == 'allPostagens')
                <th>Autor</th>
                @endif
                <th>Data de Criação</th>
                <th style="width: 10%">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($postagens as $postagem)
            <tr>
                <td class="text-start fw-bold">{{ $postagem->titulo }}</td>
                @if($tipoAba == 'allPostagens')
                <td>{{ $postagem->user->name }}</td>
                @endif
                <td>{{ $postagem->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="form-button-action">
                        <button type="button" class="btn btn-info btn-edit"
                            data-bs-toggle="tooltip"
                            data-url="{{ route('postagens.edit', $postagem->id) }}"
                            data-original-title="Editar">
                            Editar
                        </button>
                        <button type="button" class="btn btn-danger btn-remove"
                            data-bs-toggle="tooltip"
                            data-original-title="Remover"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('postagens.destroy') }}"
                            data-id="{{ $postagem->id }}">
                            Excluir
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Nenhuma postagem encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginação -->
<div class="d-flex justify-content-center mt-3">
    {{ $postagens->appends(request()->except($tipoAba.'_page'))->links('vendor.pagination.bootstrap-5') }}
</div>