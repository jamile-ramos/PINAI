@props(['publicacoes' => [], 'routeName' => '', 'tipo' => '', 'titulo' => '', 'dataEdit' => ''])

<!-- Tabel de Categorias -->
<div class="card" id="tabela-categorias">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title title-my">{{ $titulo }}</h4>
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
                        <th>Data de publicação</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Usuário resposavel pela publicação</th>
                        <th>Categoria</th>
                        <th>Data de publicação</th>
                        <th>Ação</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($publicacoes as $publicacao)
                    @if ($loop->index % 2 == 0)
                    <tr>
                        <td>{{ $publicacao->titulo }}</td>
                        <td>{{ $publicacao->categoria->nomeCategoria }}</td>
                        <td>{{ \Carbon\Carbon::parse($publicacao->created_at)->format('d/m/Y') }}</td>
                        <td class="buttons-table">
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-warning btn-edit">Ver
                                </button>
                            </div>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-info btn-edit"
                                    data-id = "{{ $publicacao->id }}"
                                    data-tipo = "{{ $tipo }}"
                                    data-edit="{{ $dataEdit }}"
                                    >Editar
                                </button>
                            </div>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-danger btn-excluirNoticia"
                                    data-id = "{{ $publicacao->id }}"
                                    data-tipo = "{{ $tipo }}"
                                    >Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td>{{ $publicacao->titulo }}</td>
                        <td>{{ $publicacao->categoria->nomeCategoria }}</td>
                        <td>{{ \Carbon\Carbon::parse($publicacao->created_at)->format('d/m/Y') }}</td>
                        <td class="buttons-table">
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-warning btn-view">Ver 
                                </button>
                            </div>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-info btn-edit"
                                    data-id = "{{ $publicacao->id }}"
                                    data-tipo = "{{ $tipo }}"
                                    data-edit="{{ $dataEdit }}">Editar
                                </button>
                            </div>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-danger btn-excluirNoticia"
                                    data-id = "{{ $publicacao->id }}"
                                    data-tipo = "{{ $tipo }}"
                                    >Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @endforeach

                    @if(empty($publicacoes))
                    <tr>
                        <td colspan="3">Não há registros</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<x-modal-exclusao :routeName="$routeName">

</x-modal-exclusao>