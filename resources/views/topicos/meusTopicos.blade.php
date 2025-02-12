<div class="forum mt-4">
    <div class="table-responsive table-bordas">
        <table class="table table-hover table-striped">
            <thead class="forum-azul">
                <tr>
                    <th class="text-center">Título</th>
                    <th class="text-center">Data de Criação</th>
                    @if($title == 'Tópicos Sugeridos')
                    <th class="text-center">Status</th>
                    @endif
                    <th class="text-center" style="width: 10%">Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($itens as $item)
                <tr>
                    <td class="text-start fw-bold">{{ $item->titulo }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>

                    @if($title == 'Tópicos Sugeridos')
                    <td class="text-center">{{ $item->getStatusNomeAttribute() }}</td>
                    <td class="text-center">
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
                    <td class="text-center">
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
                    <td colspan="4" class="text-center text-muted">Nenhum tópico encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<nav aria-label="Paginação">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Anterior</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active">
                <a class="page-link" href="#">2 <span class="visually-hidden"></span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Próximo</a>
            </li>
        </ul>
    </nav>