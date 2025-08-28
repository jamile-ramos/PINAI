<!-- Modal de mudança de status -->
<div class="modal fade" id="modalConfirmacaoTopico" tabindex="-1" aria-labelledby="modalTituloConfirmacao" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fs-5 modal-title fw-bold" id="modalTituloConfirmacao">Alterar status</h2>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modalCorpoConfirmacao pb-0">
                <!-- Formulário mudar situacao do topico sugerido -->
                <form id="formConfirmacaoTopico" data-route="{{ route('sugestoes.updateStatusSituacao', ':id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                    <label for="statusSelect" class="form-label">Status:</label>
                        <select class="form-control" name="status" id="statusSelect">
                            <option value="pendente">Pendente</option>
                            <option value="aprovado">Aprovado</option>
                            <option value="reprovado">Reprovado</option>
                        </select>
                    </div>
                    <p class="text-obs"><strong>Observação:</strong> Ao aprovar este tópico, ele será disponibilizado na lista de tópicos nos quais os usuários poderão criar postagens.</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="botaoConfirmacaoTopico" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
