<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title">Minhas Notícias</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="add-row" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Data de Criação</th>
                        <th style="width: 10%">Ação</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Data de Criação</th>
                        <th style="width: 10%">Ações</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse($minhasNoticias as $noticia)
                    <tr>
                        <td>{{ $noticia->titulo }}</td>
                        <td>{{ $noticia->categoria->nomeCategoria }}</td>
                        <td>{{ $noticia->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="form-button-action">
                                <button type="button" data-bs-toggle="tooltip"
                                    class="btn btn-info btn-edit"
                                    data-url="{{ route('noticias.edit', $noticia->id) }}"
                                    data-original-title="Editar">
                                    Editar
                                </button>
                                <button type="button" data-bs-toggle="tooltip"
                                    class="btn btn-danger btn-remove"
                                    data-original-title="Excluir"
                                    data-modal="#confirmExcluirModal"
                                    data-url="{{ route('noticias.delete') }}"
                                    data-id="{{ $noticia->id }}"
                                    data-bs-toggle="tooltip" 
                                    title="Excluir">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Nenhuma notícia encontrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>