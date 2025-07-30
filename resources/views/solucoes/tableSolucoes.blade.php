<div class="table-responsive">
    @if(request()->filled('query') && $abaAtiva === $tipoAba)
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $solucoes->total() }} resultado{{ $solucoes->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('solucoes.index') }}?abaAtiva={{ request('abaAtiva') }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @endif
    <h2 class="fw-bold text-primary mb-3 d-flex justify-content-center align-items-center">
    </h2>
    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Público-alvo</th>
                @if($tipoAba == 'allSolucoes')
                <th>Autor</th>
                @endif
                <th>Data de criação</th>
                <th style="width: 10%">Ações</th>
            </tr>
        </thead>
        <tbody>
            @if(!$solucoes->isEmpty())
            @foreach($solucoes as $solucao)
            <tr>
                <td class="fw-bold">{{ $solucao->titulo }}</td>
                <td class="text-start">
                    {{ $solucao->categoria->nomeCategoria }}
                </td>
                <td>
                    @if($solucao->publicosAlvo->count())
                    @foreach($solucao->publicosAlvo as $publico)
                    <span class="badge bg-secondary me-1 mb-1">{{ $publico->nome }}</span>
                    @endforeach
                    @else
                    <span class="text-muted">Nenhum público cadastrado</span>
                    @endif
                </td>
                @if($tipoAba == 'allSolucoes')
                <td class="text-start">
                    {{ $solucao->user->name }}
                </td>
                @endif
                <td class="text-start">
                    {{ $solucao->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <div class="form-button-action">
                        <a class="btn btn-visualizar" href="{{ route('solucoes.show', ['id' => $solucao->id]) }}" aria-label="Ver solução">
                            Ver solução
                        </a>
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-info btn-edit"
                            data-url="{{ route('solucoes.edit', $solucao->id) }}"
                            data-original-title="Editar"
                            aria-label="Editar solução">
                            Editar
                        </button>
                        <button type="button"
                            class="btn btn-danger btn-remove"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmExcluirModal"
                            title="Excluir"
                            aria-label="Excluir solução"
                            data-url="{{ route('solucoes.destroy', $solucao->id) }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            @php
            $colspan = ($tipoAba == 'allSolucoes') ? 6 : 5;
            @endphp
            <tr>
                <td colspan="{{ $colspan }}" class="text-center">Nenhuma solução encontrada!</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Paginação -->
<div class="d-flex justify-content-center mt-3">
    {{ $solucoes->appends(request()->except($tipoAba.'_page'))->links('vendor.pagination.bootstrap-5') }}
</div>