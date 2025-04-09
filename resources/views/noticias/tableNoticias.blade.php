<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                @if($tipoAba == 'allNoticias')
                <th>Autor</th>
                @endif
                <th>Data de criação</th>
                <th style="width: 10%">Ação</th>
            </tr>
        </thead>
        <tbody>
            @if(!$noticias->isEmpty())
            @foreach($noticias as $noticia)
            <tr>
                <td class="fw-bold">{{ $noticia->titulo }}</td>
                <td class="text-start">
                    {{ $noticia->categoria->nomeCategoria }}
                </td>
                @if($tipoAba == 'allNoticias')
                <td class="text-start">
                    {{ $noticia->user->name }}
                </td>
                @endif
                <td class="text-start">
                    {{ $noticia->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <div class="form-button-action">
                        <a class="btn btn-visualizar" href="{{ route('noticias.show', ['id' => $noticia->id]) }}" aria-label="Ver a notícia">
                            Ver notícia
                        </a>
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-info btn-edit"
                            data-url="{{ route('noticias.edit', $noticia->id) }}"
                            data-original-title="Editar"
                            aria-label="Editar notícia">
                            Editar
                        </button>
                        <button type="button" data-bs-toggle="tooltip"
                            class="btn btn-danger btn-remove"
                            data-original-title="Excluir"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('noticias.destroy') }}"
                            data-id="{{ $noticia->id }}"
                            title="Excluir"
                            aria-label="Excluir notícia">
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