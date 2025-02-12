<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title">Minhas Postagens</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="add-row" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Título da postagem</th>
                        <th>Tópico</th>
                        <th>Data de Criação</th>
                        <th style="width: 10%">Ações</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Título da postagem</th>
                        <th>Tópico</th>
                        <th>Data de Criação</th>
                        <th style="width: 10%">Ações</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse($itens as $item)
                        <tr>
                            <td>{{ $item->titulo }}</td>
                            <td>{{ $item->topico->titulo }}</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="form-button-action">
                                    <button type="button" class="btn btn-info btn-edit" 
                                        data-bs-toggle="tooltip" 
                                        data-url="{{ route('postagens.edit', $item->id) }}" 
                                        data-original-title="Editar">
                                        Editar
                                    </button>
                                    <button type="button" class="btn btn-danger btn-remove" 
                                        data-bs-toggle="tooltip" 
                                        data-original-title="Remover"
                                        data-modal="#confirmExcluirModal"
                                        data-url="{{ route('postagens.delete') }}" 
                                        data-id="{{ $item->id }}">
                                        Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhuma postagem encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
