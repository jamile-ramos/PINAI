<section class="forum">


    @if(request()->filled('query') && $abaAtiva === 'visaoTopicos')
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $topicos->total() }} resultado{{ $topicos->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('topicos.index', ['abaAtiva' => request('abaAtiva')]) }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @endif

    {{-- Bloco exibido apenas em telas médias para cima (>= 768px) --}}
    <div class="table-responsive table-bordas d-none d-md-block borda-alto-contraste">
        <table class="table table-hover table-striped">
            <thead class="forum-azul">
                <tr>
                    <th>Tópicos</th>
                    <th>Postagens</th>
                    <th>Última Atualização</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topicos as $topico)
                <tr>
                    <td>
                        <a href="{{ route('topicos.show', ['id' => $topico->id, 'slug' => $topico->slug]) }}" class="fw-bold">
                            {{ $topico->titulo }}
                        </a>
                    </td>
                    <td><i class="fas fa-comments text-primary me-1" aria-hidden="true"></i> {{ $topico->postagens_count }}</td>
                    <td>
                        {{ optional($topico->ultimaAtividade)->format('d/m/Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Nenhum tópico encontrado!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Bloco exibido apenas em telas pequenas (< 768px) --}}
    <div class="d-block d-md-none">
        @forelse($topicos as $topico)
        <div class="card mb-3 shadow-md">
            <div class="card-body">
                <h5 class="card-title fw-bold mt-0">
                    <a href="{{ route('topicos.show', ['id' => $topico->id, 'slug' => $topico->slug]) }}">
                        {{ $topico->titulo }}
                    </a>
                </h5>
                <p class="mb-1">
                    <i class="fas fa-comments text-primary me-1" aria-hidden="true"></i>
                    {{ $topico->postagens_count }} postagens
                </p>

                @if($topico->postagens->isNotEmpty())
                <p class="mb-0 text-muted">
                    <i class="fas fa-calendar-alt text-primary me-1" aria-hidden="true"></i>
                    Atualizado em: {{ $topico->postagens->first()->updated_at->format('d/m/Y H:i') }}
                </p>
                @endif
            </div>
        </div>
        @empty
        <p class="text-center text-muted">Nenhum tópico encontrado!</p>
        @endforelse
    </div>

    {{-- Paginação (vale para os dois formatos) --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $topicos->appends(request()->except('topicos_page'))->links('vendor.pagination.bootstrap-5') }}
    </div>

</section>