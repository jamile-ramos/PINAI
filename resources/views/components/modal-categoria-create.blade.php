<!-- Modal -->
<div class="modal fade" id="modalCategoria" tabindex="-1" role="dialog" aria-labelledby="modalCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-header">
                    <div class="card-title">Adicionar Categoria</div>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createFormCategoria" action="{{ route('categorias.store', ['tipo' => 'noticias']) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="idUsuario" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <label for="nome">Nome da Categoria</label>
                        <input type="text" class="form-control" id="nomeCategoria" name="nomeCategoria" placeholder="Digite o nome da categoria">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>