<section class="forum">

    {{-- Bloco exibido apenas em telas médias para cima (>= 768px) --}}
    <div class="table-responsive table-bordas d-none d-md-block">
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
                        <a href="{{ route('postagens.index', ['idTopico' => $topico->id]) }}" class="fw-bold">
                            {{ $topico->titulo }}
                        </a>
                    </td>
                    <td><i class="fas fa-comments text-primary me-1" aria-hidden="true"></i> {{ $topico->postagens_count }}</td>
                    <td>
                        @if($topico->postagens->isNotEmpty())
                        <i class="fas fa-calendar-alt text-primary me-1" aria-hidden="true"></i> {{ $topico->postagens->first()->updated_at->format('d/m/Y H:i') }}
                        @endif
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
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mt-0">
                    <a href="{{ route('postagens.index', ['idTopico' => $topico->id]) }}">
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