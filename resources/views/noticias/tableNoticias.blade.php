<div class="table-responsive">
    @if(request()->filled('query') && $abaAtiva == $tipoAba)
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $noticias->total() }} resultado{{ $noticias->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('noticias.index') }}?abaAtiva={{ request('abaAtiva') }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @endif

    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                @if($tipoAba == 'allNoticias')
                <th>Autor</th>
                @endif
                <th>Data de criação</th>
                <th style="width: 10%">Ações</th>
            </tr>
        </thead>
        <tbody>
        @if($noticias->isNotEmpty())
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
                <td colspan="5" class="text-center">Nenhuma notícia encontrada!</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Paginação -->
<div class="d-flex justify-content-center mt-3">
    {{ $noticias->appends(request()->except($tipoAba.'_page'))->links('vendor.pagination.bootstrap-5') }}
</div>