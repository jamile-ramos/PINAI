<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title">{{ $title }}</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="add-row" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Data de Criação</th>
                        @if($title == 'Tópicos Sugeridos')
                        <th>Status</th>
                        @endif
                        <th style="width: 10%">Ação</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Título</th>
                        <th>Data de Criação</th>
                        @if($title == 'Tópicos Sugeridos')
                        <th>Status</th>
                        @endif
                        <th style="width: 10%">Ações</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse($itens as $item)
                    <tr>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>

                        @if($title == 'Tópicos Sugeridos')
                        <td>{{ $item->getStatusNomeAttribute() }}</td>
                        <td>
                            <div class="form-button-action">
                                @if($item->status != 1)
                                <button
                                    type="button"
                                    class="btn btn-info btn-statusTop"
                                    data-id="{{ $item->id }}"
                                    data-selected="{{ $item->status }}">
                                    Alterar status
                                </button>
                                @else
                                <button
                                    type="button"
                                    class="btn btn-info btn-statusTop"
                                    style="visibility: hidden;">
                                    Alterar status
                                </button>
                                @endif
                                <button
                                    type="button"
                                    class="btn btn-danger btn-remove"
                                    data-modal="#confirmExcluirModal"
                                    data-id="{{ $item->id }}"
                                    data-url="{{ route('sugestoes.delete') }}"
                                    data-bs-toggle="tooltip"
                                    title="Excluir">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                        @else
                        <td>
                            <div class="form-button-action">
                                <button
                                    type="button"
                                    class="btn btn-info btn-editTopico"
                                    data-id="{{ $item->id }}">
                                    Editar
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-danger btn-remove"
                                    data-modal="#confirmExcluirModal"
                                    data-id="{{ $item->id }}"
                                    data-url="{{ route('topicos.delete') }}"
                                    data-bs-toggle="tooltip"
                                    title="Excluir">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Nenhum tópico encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>