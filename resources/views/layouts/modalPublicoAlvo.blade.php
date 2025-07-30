<!-- Modal -->
<div class="modal fade" id="modalPublicoAlvo" tabindex="-1" aria-labelledby="modalPublicoAlvoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalPublicoAlvoLabel">Público-Alvo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="publicoAlvoTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="adicionar-tab" data-bs-toggle="tab" data-bs-target="#adicionar" type="button" role="tab" aria-controls="adicionar" aria-selected="true">Adicionar</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="gerenciar-tab" data-bs-toggle="tab" data-bs-target="#gerenciar" type="button" role="tab" aria-controls="gerenciar" aria-selected="false">Gerenciar</button>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content mt-3">
                    <!-- Aba Adicionar -->
                    <div class="tab-pane fade show active" id="adicionar" role="tabpanel" aria-labelledby="adicionar-tab">
                        <form id="formAdicionarPublicoAlvo" method="POST" action="{{ route('publicosAlvo.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="nomePublico" class="form-label">Nome do Público-Alvo</label>
                                <input type="text" class="form-control" id="nomePublico" name="nome" required>
                            </div>

                            <div class="mb-3">
                                <label for="descricaoPublico" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricaoPublico" name="descricao" rows="3" placeholder="Descreva esse público-alvo"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>

                    <!-- Aba Gerenciar -->
                    <div class="tab-pane fade" id="gerenciar" role="tabpanel" aria-labelledby="gerenciar-tab">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($publicosAlvo as $publico)
                                <tr>
                                    <td>{{ $publico->nome }}</td>
                                    <td>{{ $publico->descricao }}</td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-danger btn-remove"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmExcluirModal"
                                            data-id="{{ $publico->id }}"
                                            title="Excluir"
                                            aria-label="Excluir público">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>