<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Data de criação</th>
                <th style="width: 10%">Ação</th>
            </tr>
        </thead>
        <tbody>
            @if(!$minhasNoticias->isEmpty())
            @foreach($minhasNoticias as $noticia)
            <tr>
                <td>
                    <a href="{{ route('postagens.index', ['id' => $noticia->id]) }}" class="fw-bold">
                        {{ $noticia->titulo }}
                    </a>
                </td>
                <td class="text-start">
                    {{ $noticia->categoria->nomeCategoria }}
                </td>
                <td class="text-start">
                    {{ $noticia->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <div class="form-button-action">
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-info btn-edit"
                            data-url="{{ route('noticias.edit', $noticia->id) }}"
                            data-original-title="Editar">
                            Editar
                        </button>
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-danger btn-remove"
                            data-original-title="Excluir"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('noticias.delete') }}"
                            data-id="{{ $noticia->id }}"
                            title="Excluir">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4" class="text-center text-muted">Você não criou nenhuma notícia!</td> 
            </tr>
            @endif
        </tbody>
    </table>
</div>
