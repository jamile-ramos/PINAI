<div class="table-responsive">
    @if(request()->filled('query') && $abaAtiva === $tipoAba)
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $solucoes->total() }} resultado{{ $solucoes->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('solucoes.index') }}?abaAtiva={{ request('abaAtiva') }}"
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
                    <th>Público-alvo</th>
                    @if($tipoAba == 'allSolucoes')
                    <th>Autor</th>
                    @endif
                    <th>Data de criação</th>
                    <th style="width: 10%">Ações</th>
                </tr>
            </thead>
            <tbody>
                @if(!$solucoes->isEmpty())
                @foreach($solucoes as $solucao)
                <tr>
                    <td class="fw-bold">{{ $solucao->titulo }}</td>
                    <td class="text-start">
                        {{ $solucao->categoria->nomeCategoria }}
                    </td>
                    <td>
                        @php
                        $limit = 3;
                        $publicos = $solucao->publicosAlvo;
                        $extraCount = $publicos->count() - $limit;
                        @endphp

                        @if($publicos->count())
                        @foreach($publicos->take($limit) as $publico)
                        <span class="badge bg-secondary me-1 mb-1">{{ $publico->nome }}</span>
                        @endforeach

                        @if($extraCount > 0)
                        <span class="badge bg-secondary mb-1">+ {{ $extraCount }} {{ $extraCount == 1 ? 'público' : 'públicos' }}</span>
                        @endif
                        @else
                        <span class="text-muted">Nenhum público cadastrado</span>
                        @endif
                    </td>
                    @if($tipoAba == 'allSolucoes')
                    <td class="text-start">
                        {{ $solucao->user->name }}
                    </td>
                    @endif
                    <td class="text-start">
                        {{ $solucao->created_at->format('d/m/Y') }}
                    </td>
                    <td>
                        <div class="form-button-action">
                            <a class="btn btn-visualizar" href="{{ route('solucoes.show', ['id' => $solucao->id, 'slug' => $solucao->slug]) }}" aria-label="Ver solução">
                                Ver solução
                            </a>
                            @if(Auth::user()->tipoUsuario != 'comum' || (Auth::user()->id == $solucao->idUsuario && $tipoAba == 'mySolucoes'))
                            <button type="button" data-bs-toggle="tooltip"
                                class="btn btn-info btn-edit"
                                data-url="{{ route('solucoes.edit', $solucao->id) }}"
                                data-original-title="Editar"
                                aria-label="Editar solução">
                                Editar
                            </button>
                            @endif
                            <button type="button"
                                class="btn btn-danger btn-remove"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmExcluirModal"
                                title="Excluir"
                                aria-label="Excluir solução"
                                data-url="{{ route('solucoes.destroy', $solucao->id) }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                @php
                $colspan = ($tipoAba == 'allSolucoes') ? 6 : 5;
                @endphp
                <tr>
                    <td colspan="{{ $colspan }}" class="text-center">Nenhuma solução encontrada!</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Cards mobile (768px) --}}
    <div class="d-block d-md-none">
        @forelse($solucoes as $solucao)
        <div class="card mb-3 shadow-md">
            <div class="card-body">
                <h5 class="card-title fw-bold mt-0 border-bottom border-secondary pb-2">{{ $solucao->titulo }}</h5>

                <div class="mb-2 border-bottom border-light pb-2 pt-2">
                    <div class="mb-2">
                        <i class="fas fa-folder text-primary me-1"></i><strong>Categoria:</strong> {{ $solucao->categoria->nomeCategoria }}
                    </div>

                    @if($tipoAba == 'allSolucoes')
                    <div class="mb-2">
                        <i class="fas fa-user text-primary me-1"></i><strong>Autor:</strong> {{ $solucao->user->name }}
                    </div>
                    @endif

                    <div class="mb-2">
                        <i class="fas fa-users text-primary me-1"></i><strong>Público-alvo:</strong>
                        @php
                        $limit = 2;
                        $publicos = $solucao->publicosAlvo;
                        $extraCount = $publicos->count() - $limit;
                        @endphp

                        @foreach($publicos->take($limit) as $publico)
                        <span class="badge bg-secondary me-1 mb-1">{{ $publico->nome }}</span>
                        @endforeach

                        @if($extraCount > 0)
                        <span class="badge bg-secondary mb-1">+ {{ $extraCount }} {{ $extraCount == 1 ? 'público' : 'públicos' }}</span>
                        @endif
                    </div>

                    <div class="text-muted">
                        <i class="fas fa-calendar-alt text-primary me-1"></i><strong>Criado em:</strong> {{ $solucao->created_at->format('d/m/Y') }}
                    </div>
                </div>


                <div class="d-flex gap-2 flex-wrap">
                    <a class="btn btn-md btn-visualizar flex-fill text-center" href="{{ route('solucoes.show', ['id' => $solucao->id, 'slug' => $solucao->slug]) }}">Ver</a>
                    @if(Auth::user()->tipoUsuario != 'comum' || (Auth::user()->id == $solucao->idUsuario && $tipoAba == 'mySolucoes'))
                    <a class="btn btn-md btn-info flex-fill text-center" href="{{ route('solucoes.edit', $solucao->id) }}">Editar</a>
                    @endif
                    <button class="btn btn-md btn-danger btn-remove flex-fill text-center"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmExcluirModal"
                        data-url="{{ route('solucoes.destroy', $solucao->id) }}">
                        Excluir
                    </button>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-muted">Nenhuma solução encontrada!</p>
        @endforelse
    </div>
</div>

<!-- Paginação -->
<div class="d-flex justify-content-center mt-3">
    {{ $solucoes->appends(request()->except($tipoAba.'_page'))->links('vendor.pagination.bootstrap-5') }}
</div>