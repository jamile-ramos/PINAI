<div class="forum-container">
    <!-- Postagem 1 -->
    @if($postagens->isEmpty())
    <div class="card shadow-sm mb-4 border-start border-4 border-primary p-4">
        <div class="card-body">
            <h4 class="card-title text-primary">
                <i class="fa-solid fa-comments me-2"></i> {{ $topico->titulo }}
            </h4>
            <p class="card-text text-muted">Veja abaixo as postagens relacionadas a este tópico</p>
        </div>
    </div>
    <p>Não há postagens nesse tópico.</p>
    @else
    <div class="card shadow-sm mb-4 border-start border-4 border-primary">
        <div class="card-body">
            <h4 class="card-title text-primary">
                <i class="fa-solid fa-comments me-2"></i> {{ $topico->titulo }}
            </h4>
            <p class="card-text text-muted">Veja abaixo as postagens relacionadas a este tópico</p>
        </div>
    </div>


    @if(request()->filled('query') && $abaAtiva === 'visaoPostagens')
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $postagens->total() }} resultado{{ $postagens->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('postagens.index', ['idTopico' => $topico->id]) }}?abaAtiva={{ request('abaAtiva') }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @endif

    @foreach($postagens as $postagem)
    <div class="post-card">
        <div class="post-header">
            <div class="post-author">
                <div class="user-icon-circle user-post">
                    <i class="fa fa-user"></i>
                </div>
                <span>Postado por <strong>{{ $postagem->user->name }}</strong></span>
            </div>
            <span>{{ $postagem->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="post-title">{{ $postagem->titulo }}</div>
        <div class="post-content">
            {{ Str::limit($postagem->conteudo, 100, '...') }}
        </div>
        <div class="post-footer">
            <a href="{{ route('postagens.show', $postagem->id )}}" class="btn btn-primary">Ver Respostas</a>
            <span><i class="fa-regular fa-comment"></i> {{ $postagem->respostas_count }} respostas</span>
        </div>
    </div>
    @endforeach
    @endif

<!-- Paginação -->
<div class="d-flex justify-content-center mt-3">
    {{ $postagens->appends(request()->except('postagens_page'))->links('vendor.pagination.bootstrap-5') }}
</div>

</div>