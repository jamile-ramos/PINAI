<!-- Modal Criar Tópico-->
<div class="modal fade" id="modalAddTopico" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title fw-bold" id="modalTopicoTitle">Adicionar Topico</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddTopico" method="POST" action="{{ route('topicos.store') }}">   
                    @csrf
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo">
                    </div>
                    <div class="modal-footer border-top pt-2 mt-2 border-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary" id="btnSalvarTopico">Salvar</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>
