<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th>Nome do arquivo</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th style="width: 10%">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentos as $documento)
            <tr>
                <td class="fw-bold">{{ $documento->nomeArquivo }}</td>
                <td class="text-start">
                    {{ $documento->descricao }}
                </td>
                <td class="text-start">
                    {{ $documento->categoria_documento->nome }}
                </td>
                <td>
                    <div class="form-button-action">
                        <a class="btn btn-visualizar" href="{{ asset('storage/' . $documento->caminhoArquivo) }}" aria-label="Visualizar documento">
                            Visualizar
                        </a>
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-info btn-edit"
                            data-url="{{ route('documentos.edit', $documento->id) }}"
                            data-original-title="Editar"
                            aria-label="Editar notícia">
                            Editar
                        </button>
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-danger btn-remove"
                            data-original-title="Excluir"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('documentos.destroy')}}"
                            data-id="{{ $documento->id }}"
                            title="Excluir"
                            aria-label="Excluir notícia">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Você não adicionou nenhum documento!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>