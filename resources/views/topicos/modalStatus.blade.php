<!-- Modal de mudança de status -->
<div class="modal fade" id="modalConfirmacaoTopico" tabindex="-1" aria-labelledby="modalTituloConfirmacao" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTituloConfirmacao">Confirmar Ação</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modalCorpoConfirmacao">
                <div class="mensagemConfirmacaoTopico">
                    <p>Tem certeza de que deseja desativar este usuário?</p>
                </div>
                <!-- Formulário para desativar o usuário -->
                <form id="formConfirmacaoTopico" data-route="{{ route('painel.updateStatus', ':id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" id="status">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="botaoConfirmacaoTopico" class="btn btn-danger">Desabilitar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
