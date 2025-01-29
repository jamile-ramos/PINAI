<div class="card">
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
                        <th style="width: 10%">Ação</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Usuário resposavel pela publicação</th>
                        <th>Categoria</th>
                        <th>Acão</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($categorias as $categoria)
                    @if($loop-> index % 2 == 0 )
                    <tr>
                        <td>{{ $categoria->user->name }}</td>
                        <td>{{ $categoria->nomeCategoria }}</td>
                        <td>
                            <div class="form-button-action">
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    title=""
                                    class="btn btn-danger"
                                    data-original-title="Remove">
                                    Excluir
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
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    title=""
                                    class="btn btn-danger"
                                    data-original-title="Remove">
                                    Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>