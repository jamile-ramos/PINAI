<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th>Título da postagem</th>
                <th>Tópico</th>
                <th>Data de Criação</th>
                <th style="width: 10%">Ações</th>
            </tr>
        </thead>
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
                            data-url="{{ route('postagens.destroy') }}"
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