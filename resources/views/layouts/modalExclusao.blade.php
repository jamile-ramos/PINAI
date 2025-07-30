<!-- Modal de exclusão -->
<div class="modal fade" id="confirmExcluirModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="confirmModalLabel">Confirmar Ação</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body body-confirmar">
                <div class="texto-confirmar">
                    <p>Tem certeza de que deseja excluir este registro?</p>
                </div>
                <!-- Formulário para desativar o usuário -->
                <form id="confirmExcluirForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="confirmActionBtn" class="btn btn-danger">Excluir</button>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>