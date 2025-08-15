<div class="table-responsive">

    @php
    if (str_contains($abaAtiva, 'categorias')){
    $abaAtiva = 'categorias';
    }
    @endphp

    @if(request('query') && $abaAtiva === 'categorias')
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $categorias->total() }} resultado{{ $categorias->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ url(request()->path()) }}?abaAtiva={{ request('abaAtiva') }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @endif

    <table class="table table-hover table-striped d-none d-md-table w-100">
        <thead class="forum-azul">
            <tr>
                <th style="width: 50%">Categoria</th>
                <th>Usuário responsável pela publicação</th>
                <th style="width: 10%">Ação</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categorias as $categoria)
            <tr>
                <td>{{ $categoria->nomeCategoria }}</td>
                <td>{{ $categoria->user->name }}</td>

                <td>
                    <div class="form-button-action">
                        <button type="button"
                            class="btn btn-danger btn-remove"
                            data-bs-toggle="tooltip"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('categorias.destroy', ['tipo' => $tipo, 'id' => $categoria->id]) }}"
                            data-id="{{ $categoria->id }}"
                            title="Excluir">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Nenhuma categoria encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Cards mobile (768px) --}}
    <div class="d-block d-md-none">
        @forelse($categorias as $categoria)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                {{-- Título da Categoria --}}
                <h5 class="card-title fw-bold border-bottom pb-2 mt-0">{{ $categoria->nomeCategoria }}</h5>

                <div class="mb-2 border-bottom border-light pb-2 pt-2">
                    <p class="mb-2">
                        <i class="fas fa-user text-primary me-1" aria-hidden="true"></i>
                        <span class="fw-semibold">Usuário responsável:</span> {{ $categoria->user->name }}
                    </p>
                </div>
                {{-- Usuário responsável --}}

                {{-- Botão de ação --}}
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-sm btn-danger flex-fill text-center btn-remove"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmExcluirModal"
                        data-url="{{ route('categorias.destroy', ['tipo' => $tipo, 'id' => $categoria->id]) }}"
                        data-id="{{ $categoria->id }}"
                        aria-label="Excluir categoria {{ $categoria->nomeCategoria }}">
                        <i class="fas fa-trash-alt me-1" aria-hidden="true"></i>
                        Excluir
                    </button>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-muted">Nenhuma categoria encontrada.</p>
        @endforelse
    </div>


</div>

<div class="d-flex justify-content-center mt-3">
    {{ $categorias->appends(request()->except($tipo.'_page'))->links('vendor.pagination.bootstrap-5') }}
</div>