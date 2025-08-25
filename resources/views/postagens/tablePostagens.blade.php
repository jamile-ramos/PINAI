<div class="table-responsive">
    @if(request()->filled('query') && $abaAtiva == $tipoAba)
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $postagens->total() }} resultado{{ $postagens->total() > 1 ? 's' : '' }} para:
            <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('topicos.show', ['id' => $topico->id, 'slug' => $topico->slug]) }}?abaAtiva={{ request('abaAtiva') }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @endif

    {{-- Bloco exibido em telas grandes (>= 768px) --}}
    <div class="d-none d-md-block">
        <table class="table table-striped table-hover">
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
                            <a class="btn btn-visualizar" href="{{ route('postagens.show', ['id' => $postagem->id, 'slug' => $postagem->slug]) }}" aria-label="Ver postagem">
                                Ver postagem
                            </a>
                            @if(Auth::user()->tipoUsuario == 'admin' || (Auth::user()->id == $postagem->idUsuario && $tipoAba == 'myPostagens'))
                            <button type="button" class="btn btn-info btn-edit"
                                data-bs-toggle="tooltip"
                                data-url="{{ route('postagens.edit', $postagem->id) }}"
                                data-original-title="Editar">
                                Editar
                            </button>
                            @endif
                            <button type="button" class="btn btn-danger btn-remove"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmExcluirModal"
                                data-original-title="Remover"
                                data-modal="#confirmExcluirModal"
                                data-url="{{ route('postagens.destroy', $postagem->id) }}">
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
</div>

{{-- Versão em cards para mobile (< 768px) --}}
<div class="d-block d-md-none">
    @forelse($postagens as $postagem)
    <div class="card mb-3 shadow-md">
        <div class="card-body">
            <h5 class="card-title fw-bold mt-0 border-bottom border-secondary pb-2">{{ $postagem->titulo }}</h5>

            <div class="mb-2 border-bottom border-light pb-2 pt-2">
                @if($tipoAba == 'allPostagens')
                <p class="mb-1"><strong><i class="fas fa-user text-primary me-1" aria-hidden="true"></i> Autor:</strong> {{ $postagem->user->name }}</p>
                @endif
                <p class="mb-1"><strong><i class="fas fa-calendar-alt text-primary me-1" aria-hidden="true"></i> Criada em::</strong> {{ $postagem->created_at->format('d/m/Y') }}</p>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a class="btn btn-md btn-visualizar flex-fill text-center" href="{{ route('postagens.show', ['id' => $postagem->id, 'slug' => $postagem->slug]) }}">
                    Ver
                </a>
                @if(Auth::user()->tipoUsuario == 'admin' || (Auth::user()->id == $postagem->idUsuario && $tipoAba == 'myPostagens'))
                <button type="button" class="btn btn-info btn-md btn-edit flex-fill text-center"
                    data-bs-toggle="tooltip"
                    data-url="{{ route('postagens.edit', $postagem->id) }}"
                    data-original-title="Editar">
                    Editar
                </button>
                @endif
                <button type="button" class="btn btn-danger btn-md btn-remove flex-fill text-center"
                    data-bs-toggle="tooltip"
                    data-original-title="Remover"
                    data-modal="#confirmExcluirModal"
                    data-url="{{ route('postagens.destroy', $postagem->id) }}">
                    Excluir
                </button>
            </div>
        </div>
    </div>
    @empty
    <p class="text-center text-muted">Nenhuma postagem encontrada.</p>
    @endforelse
</div>

<!-- Paginação -->
<div class="d-flex justify-content-center mt-3">
    {{ $postagens->appends(request()->except($tipoAba.'_page'))->links('vendor.pagination.bootstrap-5') }}
</div>