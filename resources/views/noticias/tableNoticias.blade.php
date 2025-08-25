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

    <div class="d-none d-md-block">
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
                        <div class="d-flex gap-2 flex-fill form-button-action">
                            <a class="btn btn-visualizar flex-fill" href="{{ route('noticias.show', ['id' => $noticia->id, 'slug' => $noticia->slug]) }}" aria-label="Ver a notícia">
                                Ver notícia
                            </a>
                            @if(Auth::user()->tipoUsuario != 'comum' || (Auth::user()->id == $noticia->idUsuario && $tipoAba == 'myNoticias'))
                            <button type="button" data-bs-toggle="tooltip"
                                class="btn btn-info btn-edit flex-fill"
                                data-url="{{ route('noticias.edit', $noticia->id) }}"
                                data-original-title="Editar"
                                aria-label="Editar notícia">
                                Editar
                            </button>
                            @endif
                            <button type="button"
                                class="btn btn-danger btn-remove flex-fill"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmExcluirModal"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Excluir"
                                aria-label="Excluir notícia"
                                data-url="{{ route('noticias.destroy', $noticia->id) }}">
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

    {{-- Versão em cards (somente para mobile) --}}
    <div class="d-block d-md-none">
        @forelse($noticias as $noticia)
        <div class="card mb-3 shadow-md">
            <div class="card-body">
                <h5 class="card-title fw-bold mt-0 border-bottom border-secondary pb-2">
                    {{ $noticia->titulo }}
                </h5>
                <div class="mb-2 border-bottom border-light pb-2 pt-2">
                    {{-- Categoria --}}
                    <p class="mb-1">
                        <i class="fas fa-folder text-primary me-1" aria-hidden="true"></i>
                        {{ $noticia->categoria->nomeCategoria }}
                    </p>

                    {{-- Autor --}}
                    @if($tipoAba == 'allNoticias')
                    <p class="mb-1">
                        <i class="fas fa-user-edit text-primary me-1" aria-hidden="true"></i>Por: {{ $noticia->user->name }}
                    </p>
                    @endif

                    {{-- Data de criação --}}
                    <p class="mb-2 text-muted">
                        <i class="fas fa-calendar-alt text-primary me-1" aria-hidden="true"></i>
                        Criada em: {{ $noticia->created_at->format('d/m/Y') }}
                    </p>
                </div>

                <div class="d-flex gap-2 flex-wrap pt-2">
                    <a class="btn btn-md btn-visualizar flex-fill text-center" href="{{ route('noticias.show', ['id' => $noticia->id, 'slug' => $noticia->slug]) }}">
                        Ver
                    </a>
                    @if(Auth::user()->tipoUsuario != 'comum' && $tipoAba == 'allNoticias')
                    <a class="btn btn-md btn-info flex-fill text-center" href="{{ route('noticias.edit', $noticia->id) }}">
                        Editar
                    </a>
                    @endif
                    <button class="btn btn-md btn-danger btn-remove flex-fill text-center"
                        data-bs-toggle="modal"
                        data-original-title="Remover"
                        data-bs-target="#confirmExcluirModal"
                        data-url="{{ route('noticias.destroy', $noticia->id) }}">
                        Excluir
                    </button>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-muted">Nenhuma notícia encontrada!</p>
        @endforelse
    </div>

</div>

<!-- Paginação -->
<div class="d-flex justify-content-center mt-3">
    {{ $noticias->appends(request()->except($tipoAba.'_page'))->links('vendor.pagination.bootstrap-5') }}
</div>