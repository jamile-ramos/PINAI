<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th class="text-center">Usuário responsável pela publicação</th>
                <th class="text-center">Categoria</th>
                <th style="width: 10%">Ação</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categorias as $categoria)
            <tr>
                <td>{{ $categoria->user->name }}</td>
                <td>{{ $categoria->nomeCategoria }}</td>
                <td>
                    <div class="form-button-action">
                        <button type="button"
                            data-bs-toggle="tooltip"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('categorias.delete', ['tipo' => $tipo]) }}"
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