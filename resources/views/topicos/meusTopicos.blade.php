<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title">{{ $title }}</h4>
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
                        <th>Data de Criacão</th>
                        @if($title == 'Tópicos Sugeridos')
                        <th>Status</th>
                        @endif
                        <th style="width: 10%">Ação</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Título</th>
                        <th>Data de Criacão</th>
                        @if($title == 'Tópicos Sugeridos')
                        <th>Status</th>
                        @endif
                        <th style="width: 10%">Ações</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if($itens->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Nenhum tópico encontrado.</td>
                    </tr>
                    @else
                    @foreach($itens as $item)
                    @if($loop->index % 2 == 0)
                    <tr>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                        
                        @if($title == 'Tópicos Sugeridos')
                        <th>{{ $item->status_nome }}</th>
                        <td>
                            <div class="form-button-action">
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-success btn-statusTop"
                                    data-original-title="Edit Task"
                                    data-id="{{ $item->id }}"
                                    data-value="1">
                                    Aprovar
                                </button>
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-danger btn-statusTop"
                                    data-original-title="Remove"
                                    data-modal="#confirmExcluirModal"
                                    data-id="{{ $item->id }}"
                                    data-value="2">
                                    Reprovar
                                </button>
                            </div>
                        </td>
                        @else
                        <td>
                            <div class="form-button-action">
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-info btn-editTopico"
                                    data-original-title="Edit Task"
                                    data-id="{{ $item->id }}">
                                    Editar
                                </button>
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-danger btn-remove"
                                    data-original-title="Remove"
                                    data-modal="#confirmExcluirModal"
                                    data-id="{{ $item->id }}"
                                    data-url="{{ route('topicos.delete') }}">
                                    Excluir
                                </button>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @else
                    <tr>
                        <td>{{ $item->titulo }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                        @if($title == 'Tópicos Sugeridos')
                        <th>{{ $item->status_nome }}</th>
                        <td>
                            <div class="form-button-action">
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-success btn-statusTop"
                                    data-original-title="Edit Task"
                                    data-id="{{ $item->id }}"
                                    data-value="1">
                                    Aprovar
                                </button>
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-danger btn-statusTop"
                                    data-original-title="Remove"
                                    data-modal="#confirmExcluirModal"
                                    data-id="{{ $item->id }}"
                                    data-url="{{ route('topicos.delete') }}"
                                    data-value="2">
                                    Reprovar
                                </button>
                            </div>
                        </td>
                        @else
                        <td>
                            <div class="form-button-action">
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-info btn-editTopico"
                                    data-original-title="Edit Task"
                                    data-id="{{ $item->id }}">
                                    Editar
                                </button>
                                <button
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-danger btn-remove"
                                    data-original-title="Remove"
                                    data-modal="#confirmExcluirModal"
                                    data-id="{{ $item->id }}"
                                    data-url="{{ route('topicos.delete') }}">
                                    Excluir
                                </button>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endif
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>