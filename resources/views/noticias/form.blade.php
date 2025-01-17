<!-- Modal criar noticia -->
<div class="modal fade" id="criarNoticiaModal" tabindex="-1" aria-labelledby="criarNoticiaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="card-header">
                    <div class="card-title">{{ isset($noticia) ? 'Editar Notícia' : 'Adicionar Notícia' }}</div>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form data-modal="true" id="formNoticia" action="{{ isset($noticia) ? route('noticias.update', $noticia->id) : route('noticias.create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if(isset($noticia))
                        @method('PUT')
                    @endif
                    <!-- Campo Título -->
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input
                            name="titulo"
                            type="text"
                            class="form-control form-control"
                            id="titulo"
                            value="{{ old('titulo', $noticia->titulo ?? '') }}"
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
                            value = "{{ old('subtitulo', $noticia->subtitulo ?? '') }}"
                            placeholder="Digite o subtítulo" />
                    </div>

                    <!-- Campo Conteúdo -->
                    <div class="form-group">
                        <label for="conteudo">Conteúdo da notícia</label>
                        <textarea 
                        name="conteudo" 
                        class="form-control" 
                        id="conteudo" 
                        value="{{ old('conteudo', $noticia->conteudo ?? '') }}"
                        rows="10"></textarea>
                    </div>

                    <!-- Campo Imagem -->
                    <div class="form-group" id="campo-imagem">
                        <label for="imagem">Imagem</label>
                        <input
                            name="imagem"
                            type="file"
                            class="form-control-file"
                            id="imagem" />
                    </div>

                    @if(isset($noticia) && $noticia->imagem)
                    <!-- Imagem de pré-visualização -->
                    <div id="imagem-preview-container" style="display: none;">
                        <img id="imagem-preview" src="{{ Storage::url($noticia->imagem) }}" alt="Imagem Atual" style="max-width: 200px; margin-top: 15px;">
                        <button type="button" id="remove-imagem" class="btn btn-danger">Remover Imagem</button>
                    </div>
                    @endif

                    <!-- Campo Categoria -->
                    <div class="form-group">
                        <label for="categoria">Categoria</label>
                        <select name="categoria" class="form-select form-control" id="categoria" data-tipo='noticias'>
                            <option value="" disabled selected>Carregando categorias...</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" form="formulario-modal-create">Salvar</button>
            </div>
        </div>
    </div>
</div>