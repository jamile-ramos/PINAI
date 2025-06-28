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

    <table class="table table-hover table-striped">
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
                            data-bs-toggle="tooltip"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('categorias.destroy', ['tipo' => $tipo]) }}"
                            data-id="{{ $categoria->id }}"
                            class="btn btn-danger btn-remove"
                            data-original-title="Remover"
                            data-toggle="tooltip"
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
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $categorias->appends(request()->except($tipo.'_page'))->links('vendor.pagination.bootstrap-5') }}
</div>  