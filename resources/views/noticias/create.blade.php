<!-- Modal criar noticia -->
<div class="modal fade" id="criarNoticiaModal" tabindex="-1" aria-labelledby="criarNoticiaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-header">
                    <div class="card-title">Adicionar Notícia</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario-modal">
                    <!-- Campo Título -->
                    <div class="form-group">
                        <label for="largeInput">Título</label>
                        <input
                            type="text"
                            class="form-control form-control"
                            id="defaultInput"
                            placeholder="Digite o título" />
                    </div>

                    <!-- Campo Subtítulo -->
                    <div class="form-group">
                        <label for="largeInput">Subtítulo</label>
                        <input
                            type="text"
                            class="form-control form-control"
                            id="defaultInput"
                            placeholder="Digite o subtítulo" />
                    </div>

                    <!-- Campo Conteúdo -->
                    <div class="form-group">
                        <label for="comment">Conteúdo da notícia</label>
                        <textarea class="form-control" id="comment" rows="10">
                          </textarea>
                    </div>

                    <!-- Campo Imagem -->
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Imagem</label>
                        <input
                            type="file"
                            class="form-control-file"
                            id="exampleFormControlFile1" />
                    </div>

                    <!-- Campo Categoria -->
                    <div class="form-group">
                        <label for="defaultSelect">Categoria</label>
                        <select class="form-select form-control" id="defaultSelect">
                            <option value="" disabled selected>Carregando categorias...</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" form="formulario-modal">Salvar</button>
            </div>
        </div>
    </div>
</div>