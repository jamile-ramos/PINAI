<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title">Minhas Notícias</h4>
        </div>
    </div>
    <div class="card-body">
        <!-- Modal -->
        <div
            class="modal fade"
            id="addRowModal"
            tabindex="-1"
            role="dialog"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">
                            <span class="fw-mediumbold"> New</span>
                            <span class="fw-light"> Row </span>
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="small">
                            Create a new row using this form, make sure you
                            fill them all
                        </p>
                        <form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Name</label>
                                        <input
                                            id="addName"
                                            type="text"
                                            class="form-control"
                                            placeholder="fill name" />
                                    </div>
                                </div>
                                <div class="col-md-6 pe-0">
                                    <div class="form-group form-group-default">
                                        <label>Position</label>
                                        <input
                                            id="addPosition"
                                            type="text"
                                            class="form-control"
                                            placeholder="fill position" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Office</label>
                                        <input
                                            id="addOffice"
                                            type="text"
                                            class="form-control"
                                            placeholder="fill office" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button
                            type="button"
                            id="addRowButton"
                            class="btn btn-primary">
                            Add
                        </button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table
                id="add-row"
                class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Categoria</th>
                        <th>Data de Criacão</th>
                        <th style="width: 10%">Ação</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Categoria</th>
                        <th>Data de Criacão</th>
                        <th style="width: 10%">Ações</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if($minhasNoticias->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Nenhuma Notícia encontrada.</td>
                    </tr>
                    @else
                        @foreach($minhasNoticias as $noticia)
                            @if($loop->index % 2 == 0)
                            <tr>
                                <td>{{ $noticia->titulo }}</td>
                                <td>{{ $noticia->user->name }}</td>
                                <td>{{ $noticia->categoria->nomeCategoria }}</td>
                                <td>{{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="form-button-action">
                                        <button
                                            type="button"
                                            data-bs-toggle="tooltip"
                                            title=""
                                            class="btn btn-link btn-primary btn-lg"
                                            data-original-title="Edit Task">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button
                                            type="button"
                                            data-bs-toggle="tooltip"
                                            title=""
                                            class="btn btn-link btn-danger"
                                            data-original-title="Remove">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td>{{ $noticia->titulo }}</td>
                                <td>{{ $noticia->user->name }}</td>
                                <td>{{ $noticia->categoria->nomeCategoria }}</td>
                                <td>{{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="form-button-action">
                                        <button
                                            type="button"
                                            data-bs-toggle="tooltip"
                                            title=""
                                            class="btn btn-link btn-primary btn-lg"
                                            data-original-title="Edit Task">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button
                                            type="button"
                                            data-bs-toggle="tooltip"
                                            title=""
                                            class="btn btn-link btn-danger"
                                            data-original-title="Remove">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>