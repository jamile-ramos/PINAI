<!-- Modal criar noticia -->
<div class="modal fade" id="criarNoticiaModal" tabindex="-1" aria-labelledby="criarNoticiaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-header">
                    <div class="card-title">Adicionar Notícia</div>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formulario-modal" action="/noticias/store" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Campo Título -->
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input
                            name="titulo"
                            type="text"
                            class="form-control form-control"
                            id="titulo"
                            placeholder="Digite o subtítulo" />
                    </div>

                    <!-- Campo Subtítulo -->
                    <div class="form-group">
                        <label for="subtitulo">Subtítulo</label>
                        <input
                            name="subtitulo"
                            type="text"
                            class="form-control form-control"
                            id="subtitulo"
                            placeholder="Digite o subtítulo" />
                    </div>

                    <!-- Campo Conteúdo -->
                    <div class="form-group">
                        <label for="conteudo">Conteúdo da notícia</label>
                        <textarea name="conteudo" class="form-control" id="conteudo" rows="10"></textarea>
                    </div>

                    <!-- Campo Imagem -->
                    <div class="form-group">
                        <label for="imagem">Imagem</label>
                        <input
                            name="imagem"
                            type="file"
                            class="form-control-file"
                            id="imagem" />
                    </div>

                    <!-- Campo Categoria -->
                    <div class="form-group">
                        <label for="categoria">Categoria</label>
                        <select name="categoria" class="form-select form-control" id="categoria" data-tipo='noticia'>
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