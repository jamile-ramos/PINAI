<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title">Categorias</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="add-row" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Usuário responsável pela publicação</th>
                        <th>Categoria</th>
                        <th style="width: 10%">Ação</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Usuário responsável pela publicação</th>
                        <th>Categoria</th>
                        <th>Ação</th>
                    </tr>
                </tfoot>
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
    </div>
</div>