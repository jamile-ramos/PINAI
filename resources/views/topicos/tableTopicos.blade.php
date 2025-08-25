<div class="forum">
    @if(request()->filled('query') && $abaAtiva == $tipoAba)
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $topicos->total() }} resultado{{ $topicos->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('topicos.index') }}?abaAtiva={{ request('abaAtiva') }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @endif

    <div class="table-responsive table-bordas">
        <div class="d-none d-md-block">
            <table class="table table-hover table-striped">
                <thead class="forum-azul">
                    <tr>
                        <th>Título do tópico</th>
                        @if($title == 'Gerenciar Tópicos')
                        <th>Autor</th>
                        @endif
                        @if($title == 'Tópicos Sugeridos')
                        <th>Status</th>
                        @endif
                        <th>Data de Criação</th>
                        <th style="width: 10%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topicos as $topico)
                    <tr>
                        <td class="text-start fw-bold">{{ $topico->titulo }}</td>

                        @if($title == 'Gerenciar Tópicos')
                        <td class="text-start">{{ $topico->user->name }}</td>
                        @endif

                        @if($title == 'Tópicos Sugeridos')
                        <td>{{ $topico->status_situacao }}</td>
                        @endif

                        <td>{{ \Carbon\Carbon::parse($topico->created_at)->format('d/m/Y') }}</td>

                        <td class="text-center">
                            <div class="form-button-action">
                                @if($title == 'Tópicos Sugeridos')
                                @if($topico->status_situacao != 'aprovado')
                                <button
                                    type="button"
                                    class="btn btn-info btn-statusTop"
                                    data-id="{{ $topico->id }}"
                                    data-selected="{{ $topico->getRawOriginal('status_situacao') }}">
                                    Alterar status
                                </button>
                                @else
                                <button
                                    type="button"
                                    class="btn btn-info btn-statusTop"
                                    style="visibility: hidden;">
                                    Alterar status
                                </button>
                                @endif
                                <button
                                    type="button"
                                    class="btn btn-danger btn-remove"
                                    data-modal="#confirmExcluirModal"
                                    data-url="{{ route('sugestoes.destroy', $topico->id) }}"
                                    data-bs-toggle="tooltip"
                                    title="Excluir">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                @else
                                <a class="btn btn-visualizar" href="{{ route('topicos.show', ['id' => $topico->id, 'slug' => $topico->slug]) }}" aria-label="Ver tópico">
                                    Ver Tópico
                                </a>
                                @if(Auth::user()->tipoUsuario == 'admin' || (Auth::user()->id == $topico->idUsuario && $tipoAba == 'myTopicos'))
                                <button
                                    type="button"
                                    class="btn btn-info btn-editTopico"
                                    data-id="{{ $topico->id }}">
                                    Editar
                                </button>
                                @endif
                                <button
                                    type="button"
                                    class="btn btn-danger btn-remove"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmExcluirModal"
                                    data-url="{{ route('topicos.destroy', $topico->id) }}"
                                    data-bs-toggle="tooltip"
                                    title="Excluir">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Nenhum tópico encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Cards mobile (768px) --}}
        <div class="d-block d-md-none">
            @forelse($topicos as $topico)
            <div class="card mb-3 shadow-md">
                <div class="card-body">
                    {{-- Título --}}
                    <h5 class="card-title fw-bold pb-2 border-bottom border-secondarymt-0">{{ $topico->titulo }}</h5>
                    <div class="pt-2">
                        {{-- Autor ou Status --}}
                        @if($title == 'Gerenciar Tópicos')
                        <p class="mb-1">
                            <i class="fas fa-user text-primary me-1" aria-hidden="true"></i>
                            Autor: {{ $topico->user->name }}
                        </p>
                        @endif

                        @if($title == 'Tópicos Sugeridos')
                        <p class="mb-1">
                            <i class="fas fa-info-circle text-primary me-1" aria-hidden="true"></i>
                            Status: {{ $topico->status_situacao }}
                        </p>
                        @endif

                        {{-- Data de criação --}}
                        <p class="mb-2 text-muted">
                            <i class="fas fa-calendar-alt text-primary me-1" aria-hidden="true"></i>
                            Criado em: {{ \Carbon\Carbon::parse($topico->created_at)->format('d/m/Y') }}
                        </p>
                    </div>

                    {{-- Botões --}}
                    <div class="d-flex gap-2 flex-wrap border-top pt-2 border-secondary">
                        @if($title == 'Tópicos Sugeridos')
                        @if($topico->status_situacao != 'aprovado')
                        <button type="button" class="btn btn-info btn-md flex-fill text-center btn-statusTop"
                            data-id="{{ $topico->id }}"
                            data-selected="{{ $topico->getRawOriginal('status_situacao') }}">
                            Alterar status
                        </button>
                        @endif
                        <button type="button" class="btn btn-danger btn-md flex-fill text-center btn-remove"
                            data-modal="#confirmExcluirModal"
                            data-url="{{ route('sugestoes.destroy', $topico->id) }}">
                            Excluir
                        </button>
                        @else
                        <a class="btn btn-visualizar btn-md flex-fill" href="{{ route('topicos.show', ['id' => $topico->id, 'slug' => $topico->slug]) }}" aria-label="Ver tópico">
                            Ver Tópico
                        </a>
                        @if(Auth::user()->tipoUsuario == 'admin' || (Auth::user()->id == $topico->idUsuario && $tipoAba == 'myTopicos'))
                        <button type="button" class="btn btn-info btn-md flex-fill text-center btn-editTopico"
                            data-id="{{ $topico->id }}">
                            Editar
                        </button>
                        @endif
                        <button type="button" class="btn btn-danger btn-md flex-fill text-center btn-remove"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmExcluirModal"
                            data-url="{{ route('topicos.destroy', $topico->id) }}">
                            Excluir
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-muted">Nenhum tópico encontrado.</p>
            @endforelse
        </div>

    </div>
</div>

<!-- Paginação -->
<div class="d-flex justify-content-center mt-3">
    {{ $topicos->appends(request()->except($tipoAba.'_page'))->links('vendor.pagination.bootstrap-5') }}
</div>