<div class="forum">
    @if(request()->filled('query') && $abaAtiva == $tipoAba)
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $topicos->total() }} resultado{{ $topicos->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('topicos.index') }}?abaAtiva={{ request('abaAtiva') }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @endif

    <div class="table-responsive table-bordas">
        <table class="table table-hover table-striped">
            <thead class="forum-azul">
                <tr>
                    <th>Título do tópico</th>
                    @if($title == 'Gerenciar Tópicos')
                    <th>Autor</th>
                    @endif
                    @if($title == 'Tópicos Sugeridos')
                    <th>Status</th>
                    @endif
                    <th>Data de Criação</th>
                    <th style="width: 10%">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topicos as $topico)
                <tr>
                    <td class="text-start fw-bold">{{ $topico->titulo }}</td>

                    @if($title == 'Gerenciar Tópicos')
                    <td class="text-start">{{ $topico->user->name }}</td>
                    @endif

                    @if($title == 'Tópicos Sugeridos')
                    <td>{{ $topico->status_situacao }}</td>
                    @endif

                    <td>{{ \Carbon\Carbon::parse($topico->created_at)->format('d/m/Y') }}</td>

                    <td class="text-center">
                        <div class="form-button-action">
                            @if($title == 'Tópicos Sugeridos')
                            @if($topico->status_situacao != 'aprovado')
                            <button
                                type="button"
                                class="btn btn-info btn-statusTop"
                                data-id="{{ $topico->id }}"
                                data-selected="{{ $topico->getRawOriginal('status_situacao') }}">
                                Alterar status
                            </button>
                            @else
                            <button
                                type="button"
                                class="btn btn-info btn-statusTop"
                                style="visibility: hidden;">
                                Alterar status
                            </button>
                            @endif
                            <button
                                type="button"
                                class="btn btn-danger btn-remove"
                                data-modal="#confirmExcluirModal"
                                data-id="{{ $topico->id }}"
                                data-url="{{ route('sugestoes.destroy') }}"
                                data-bs-toggle="tooltip"
                                title="Excluir">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            @else
                            <button
                                type="button"
                                class="btn btn-info btn-editTopico"
                                data-id="{{ $topico->id }}">
                                Editar
                            </button>
                            <button
                                type="button"
                                class="btn btn-danger btn-remove"
                                data-modal="#confirmExcluirModal"
                                data-id="{{ $topico->id }}"
                                data-url="{{ route('topicos.destroy') }}"
                                data-bs-toggle="tooltip"
                                title="Excluir">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Nenhum tópico encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Paginação -->
<div class="d-flex justify-content-center mt-3">
    {{ $topicos->appends(request()->except($tipoAba.'_page'))->links('vendor.pagination.bootstrap-5') }}
</div>