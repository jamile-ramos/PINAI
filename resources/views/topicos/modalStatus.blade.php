<!-- Modal de mudança de status -->
<div class="modal fade" id="modalConfirmacaoTopico" tabindex="-1" aria-labelledby="modalTituloConfirmacao" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTituloConfirmacao">Alterar status</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modalCorpoConfirmacao">
                <!-- Formulário para desativar o usuário -->
                <form id="formConfirmacaoTopico" data-route="{{ route('sugestoes.updateStatus', ':id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                    <label for="statusSelect" class="form-label">Status:</label>
                        <select class="form-control" name="status" id="statusSelect">
                            <option value="0">Pendente</option>
                            <option value="1">Aprovado</option>
                            <option value="2">Reprovado</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="botaoConfirmacaoTopico" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
