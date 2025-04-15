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
    <div class="card shadow-sm mb-4 border-start border-4 border-primary p-4">
        <div class="card-body">
            <h4 class="card-title text-primary">
                <i class="fa-solid fa-comments me-2"></i> {{ $topico->titulo }}
            </h4>
            <p class="card-text text-muted">Veja abaixo as postagens relacionadas a este tópico</p>
        </div>
    </div>

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

    <nav aria-label="Paginação">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Anterior</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active">
                <a class="page-link" href="#">2 <span class="visually-hidden"></span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Próximo</a>
            </li>
        </ul>
    </nav>

</div>