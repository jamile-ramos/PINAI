@props(['categorias' => [],'tipo' => ''])

<div class="card" id="tabela-categorias">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title">Categorias</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table
                id="add-row"
                class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Usuário resposavel pela publicação</th>
                        <th>Categoria</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Usuário resposavel pela publicação</th>
                        <th>Categoria</th>
                        <th>Ação</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($categorias as $categoria)
                    @if ($loop->index % 2 == 0)
                    <tr>
                        <td>{{ $categoria->user->name }}</td>
                        <td>{{ $categoria->nomeCategoria }}</td>
                        <td>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-danger btn-action"
                                    data-tipo="{{ $tipo }}"
                                    data-id="{{ $categoria->id }}">Excluir
                                </button>
                            </div>
                        </td>

                    </tr>
                    @else
                    <tr>
                        <td>{{ $categoria->user->name }}</td>
                        <td>{{ $categoria->nomeCategoria }}</td>
                        <td>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-danger btn-action"
                                    data-tipo="{{ $tipo }}"
                                    data-id="{{ $categoria->id }}">Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @endforeach

                    @if (empty($categorias))
                    <tr>
                        <td colspan="3">Não há categorias registradas</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm" method="POST" action="{{ route('categorias.delete', ['tipo' => ':tipo']) }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Tem certeza de que deseja excluir esta categoria?</p>
                    <input type="hidden" id="categoriaId" name="categoriaId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger .delete-btn">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>