<div class="table-responsive">
    @if(request('query') && $abaAtiva === 'all-nais')
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
    <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $nais->total() }} resultado{{ $nais->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('painel.usuarios') }}?abaAtiva={{ request('abaAtiva') }}"
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
                <th>Nome</th>
                <th>Instituição</th>
                <th>Estado</th>
                <th>Status</th>
                <th>Data de cadastro</th>
                <th style="width: 10%">Ações</th>
            </tr>
        </thead>
        <tbody id="table-nais">
            @forelse($nais as $nai)
            <tr>
                <td class="fw-bold">{{ $nai->nome }} - {{ $nai->siglaNai }}</td>
                <td>{{ $nai->siglaInstituicao }}</td>
                <td class="text-start" id="estado-{{ $nai->id }}" data-id="{{ $nai->id }}">
                    {{ $nai->estado }}
                </td>
                <td class="text-start">
                    {{ $nai->status == 'ativo' ? 'Ativo' : 'Inativo' }}
                </td>
                <td class="text-start">
                    {{ $nai->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <div class="form-button-action">
                        <a class="btn btn-visualizar" href="{{ route('nais.show', ['id' => $nai->id ]) }}" aria-label="Ver informações do Nai {{ $nai->nome }}">
                            Ver mais
                        </a>
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-primary btn-edit"
                            data-url="{{ route('nais.edit', ['id' => $nai->id ]) }}"
                            data-original-title="Editar"
                            aria-label="Editar dados do {{ $nai->nome }}">
                            Editar
                        </button>
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-danger btn-remove"
                            data-original-title="Excluir"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('nais.destroy') }}"
                            data-id="{{ $nai->id }}"
                            title="Excluir"
                            aria-label="Excluir cadastro {{ $nai->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Nenhum NAI encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-3">
        {{ $nais->appends(request()->except('nais_page'))->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>