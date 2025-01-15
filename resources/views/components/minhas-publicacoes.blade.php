@props(['noticias' => [], 'routeName' => ''])

<!-- Tabel de Categorias -->
<div class="card" id="tabela-categorias">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title title-my">Meu</h4>
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
                        <th>Data de publicacao</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Usuário resposavel pela publicação</th>
                        <th>Categoria</th>
                        <th>Ação</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($noticias as $noticia)
                    @if ($loop->index % 2 == 0)
                    <tr>
                        <td>{{ $noticia->titulo }}</td>
                        <td>{{ $noticia->categoriaNoticia->nomeCategoria }}</td>
                        <td>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-warning btn-edit">Ver
                                </button>
                            </div>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-info btn-edit">Editar
                                </button>
                            </div>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-danger btn-excluirNoticia"
                                    data-id = "{{ $noticia->id }}"
                                    >Excluir
                                </button>
                            </div>
                        </td>

                    </tr>
                    @else
                    <tr>
                        <td>{{ $noticia->titulo }}</td>
                        <td>{{ $noticia->categoriaNoticia->nomeCategoria }}</td>
                        <td>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-warning btn-edit">Ver 
                                </button>
                            </div>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-info btn-edit">Editar
                                </button>
                            </div>
                            <div class="form-button-action">
                                <button type="button"
                                    class="btn btn-danger btn-excluirNoticia"
                                    >Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @endforeach

                    @if(empty($noticias))
                    <tr>
                        <td colspan="3">Não há noticias registradas</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<x-modal-exclusao :id="$noticia->id" :routeName="$routeName">

</x-modal-exclusao>