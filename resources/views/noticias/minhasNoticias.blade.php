<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title">Minhas Notícias</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table
                id="add-row"
                class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Data de Criacão</th>
                        <th style="width: 10%">Ação</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Título</th>
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
                        <td>{{ $noticia->categoria->nomeCategoria }}</td>
                        <td>{{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <div class="form-button-action">
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-info btn-edit"
                                    data-url="{{ route('noticias.edit', $noticia->id) }}" 
                                    data-original-title="Edit Task">
                                    Editar
                                </button>
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-danger btn-remove"
                                    data-original-title="Remove"
                                    data-modal="#confirmExcluirModal"
                                    data-url="{{ route('noticias.delete') }}" 
                                    data-id="{{ $noticia->id }}">
                                    Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td>{{ $noticia->titulo }}</td>
                        <td>{{ $noticia->categoria->nomeCategoria }}</td>
                        <td>{{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <div class="form-button-action">
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-info btn-edit"
                                    data-url="{{ route('noticias.edit', $noticia->id) }}" 
                                    data-original-title="Edit Task">
                                    Editar
                                </button>
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-danger"
                                    data-original-title="Remove"
                                    data-modal="#confirmExcluirModal"
                                    data-url="{{ route('noticias.delete') }}" 
                                    data-id="{{ $noticia->id }}">
                                    Excluir
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