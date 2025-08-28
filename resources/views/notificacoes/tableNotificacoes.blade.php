<div class="table-responsive">

    {{-- Mensagem de pesquisa --}}
    @if(request()->filled('query') && isset($abaAtiva))
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $notificacoes->total() }} resultado{{ $notificacoes->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('notificacoes.index') }}?abaAtiva={{ $abaAtiva }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todas as notificações">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @endif

    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th>Título</th>
                <th>Mensagem</th>
                <th>Tipo</th>
                <th>Data</th>
                <th>Lida?</th>
                <th style="width: 25%">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notificacoes as $n)
            <tr class="{{ is_null($n->read_at) ? 'table-warning' : '' }}">
                <td>{{ $n->data['title'] }}</td>
                <td>{{ $n->data['message'] ?? '-' }}</td>
                <td>{{ $n->data['type'] ?? '-' }}</td>
                <td>{{ $n->created_at->format('d/m/Y H:i') }}</td>

                {{-- Coluna Lida --}}
                <td class="text-center">
                    @if(!is_null($n->read_at))
                    <span class="badge bg-success">Sim</span>
                    @else
                    <span class="badge bg-warning text-dark">Não</span>
                    @endif
                </td>

                {{-- Ações --}}
                <td>
                    <div class="d-flex gap-2 flex-fill form-button-action">
                        {{-- Ver Notificação --}}
                        <a href="{{ $n->data['url'] ?? '#' }}"
                            class="btn btn-sm btn-visualizar"
                            title="Visualizar Notificação">Ver</a>

                        {{-- Botão Marcar/Desmarcar como Lida --}}
                        @if(is_null($n->read_at))
                        <form method="POST" action="{{ route('notificacoes.marcarLida', ['id' => $n->id]) }}" class="flex-fill">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" title="Marcar como lida" style="width: 180px;">
                                Marcar como lida
                            </button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('notificacoes.marcarNaoLida', ['id' => $n->id]) }}" class="flex-fill">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-secondary" title="Desmarcar como lida" style="width: 180px;">
                                Desmarcar como lida
                            </button>
                        </form>
                        @endif

                        {{-- Botão Remover Notificação --}}
                        <button type="button"
                            class="btn btn-danger btn-remove"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmExcluirModal"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Excluir"
                            aria-label="Excluir notificação"
                            data-url="{{ route('notificacoes.destroy', ['id' => $n->id]) }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Nenhuma notificação encontrada!</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginação --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $notificacoes->appends(request()->except($abaAtiva.'_page'))->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>