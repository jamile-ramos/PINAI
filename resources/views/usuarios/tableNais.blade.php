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
    {{-- Table Desktop --}}
    <div class="d-none d-md-block">
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
                            <button type="button"
                                class="btn btn-danger btn-remove"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmExcluirModal"
                                data-bs-toggle="tooltip"
                                title="Excluir"
                                aria-label="Excluir cadastro {{ $nai->id }}"
                                data-url="{{ route('nais.destroy', $nai->id) }}">
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
    </div>

    {{-- Cards mobile (768px) --}}
    <div class="d-block d-md-none">
        @forelse($nais as $nai)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold pb-2 border-bottom border-secondary mt-0">{{ $nai->nome }} - {{ $nai->siglaNai }}</h5>
                <div class="mb-2 border-bottom border-light pb-2 pt-2">
                    <p class="mb-1"><i class="fas fa-building text-primary me-1"></i>Instituição: {{ $nai->siglaInstituicao }}</p>
                    <p class="mb-1"><i class="fas fa-map-marker-alt text-primary me-1"></i>Estado: {{ $nai->estado }}</p>
                    <p class="mb-1"><i class="fas fa-toggle-on text-primary me-1"></i>Status: {{ $nai->status == 'ativo' ? 'Ativo' : 'Inativo' }}</p>
                    <p class="mb-0"><i class="fas fa-calendar-alt text-primary me-1"></i>Cadastro: {{ $nai->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="d-flex gap-2 pt-2">
                    <a class="btn btn-sm btn-visualizar flex-fill text-center" href="{{ route('nais.show', ['id' => $nai->id ]) }}">
                        Ver mais
                    </a>
                    <button type="button" class="btn btn-sm btn-primary btn-edit flex-fill text-center" data-url="{{ route('nais.edit', ['id' => $nai->id ]) }}">
                        Editar
                    </button>
                    <button type="button" class="btn btn-sm btn-danger btn-remove flex-fill text-center" data-bs-toggle="modal" data-bs-target="#confirmExcluirModal" data-url="{{ route('nais.destroy', $nai->id) }}">
                        Excluir
                    </button>
                </div>

            </div>
        </div>
        @empty
        <p class="text-center text-muted">Nenhum NAI encontrado.</p>
        @endforelse
    </div>

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-3">
        {{ $nais->appends(request()->except('nais_page'))->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>