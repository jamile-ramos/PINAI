<div class="table-responsive">
    <h2 class="fw-bold text-primary mb-3 d-flex justify-content-center align-items-center">
        @if($tipoAba == 'allSolucoes')
        <i class="fas fa-lightbulb me-2"></i>
        Todas as Soluções
        @endif
    </h2>
    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Categoria</th>
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
                <td>{{ \Illuminate\Support\Str::limit($solucao->descricao, 100) }}</td>
                <td class="text-start">
                    {{ $solucao->categoria->nomeCategoria }}
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
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-danger btn-remove"
                            data-original-title="Excluir"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('solucoes.destroy') }}"
                            data-id="{{ $solucao->id }}"
                            title="Excluir"
                            aria-label="Excluir solução">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4" class="text-center">Você não criou nenhuma notícia!</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>