@props(['id' => '', 'routeName' => ''])

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="confirmDeleteModalPubli" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteFormPubli" method="POST" action="{{ route($routeName, ['id' => $id]) }}"            >
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Tem certeza de que deseja excluir esta notícia?</p>
                    <input type="hidden" id="publicacaoId" name="publicacaoId" value="{{ $id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger .delete-btn">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>