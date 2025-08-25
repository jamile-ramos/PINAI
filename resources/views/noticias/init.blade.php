<div id="conteudo-categorias">
    @if(!empty($query) && isset($noticiasBusca) && $abaAtiva === 'visaoNoticias')
    <!-- MODO DE BUSCA ATIVA -->
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $noticiasBusca->total() }} resultado{{ $noticiasBusca->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('noticias.index') }}?abaAtiva={{ request('abaAtiva') }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @if(!$noticiasBusca->isEmpty())
    <div class="home-news titulo-categoria">
        <div class="row row-cols-1 g-4">
            @foreach($noticiasBusca as $noticia)
            <div class="col card-not-home">
                <div class="card h-100 border-0 bg-transparent shadow-none">
                    <div class="row g-0 h-100">
                        <div class="col-md-4">
                            <div class="h-100 w-100 overflow-hidden">
                                <img src="{{ asset('img/imgNoticias/' . $noticia->imagem) }}"
                                    class="img-fluid rounded w-100 h-100"
                                    style="min-height: 200px; max-height: 200px; object-fit: cover;"
                                    alt="{{ $noticia->titulo }}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body d-flex flex-column h-100 bg-transparent p-0">
                                <h5 class="card-title title-new mb-2">
                                    <a href="{{ route('noticias.show', ['id' => $noticia->id, 'slug' => $noticia->slug]) }}" class="text-decoration-none text-dark" data-btn="noticias">
                                        {{ $noticia->titulo }}
                                    </a>
                                </h5>

                                <p class="card-text mb-5">{{ Str::limit($noticia->subtitulo, 150) }}</p>
                                <p class="card-text"><small class="text-muted">Publicado dia {{ $noticia->created_at->format('d/m/Y') }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- PAGINAÇÃO -->
    <div class="d-flex justify-content-center mt-3">
        {{ $noticiasBusca->appends(request()->except('noticias_page'))->links('vendor.pagination.bootstrap-5')  }}
    </div>
    @endif
    <!-- MODO PADRÃO: CARROSSEL E CATEGORIAS -->
    @else
    <div class="bd-example">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" role="region" aria-label="Carrossel de Notícias recentes">
            <div class="carousel-indicators">
                @foreach($noticiasRecentes as $index => $noticia)
                <button
                    type="button"
                    data-bs-target="#carouselExampleCaptions"
                    data-bs-slide-to="{{ $index }}"
                    class="{{ $loop->first ? 'active' : '' }}"
                    aria-current="{{ $loop->first ? 'true' : 'false' }}"
                    aria-label="Ir para slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner" aria-live="polite">
                @foreach($noticiasRecentes as $index => $noticia)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="carousel-image-container position-relative">
                        <img src="{{ asset('img/imgNoticias/' . $noticia->imagem) }}" class="d-block w-100" alt="{{ 'Imagem da notícia: ' . Str::limit($noticia->titulo, 80) }}">
                        <!-- Sombreado aplicado com gradiente -->
                        <div class="carousel-overlay position-absolute top-0 start-0 w-100 h-100"></div>
                    </div>
                    <div class="carousel-caption d-md-block">
                        <a href="{{ route('noticias.show', ['id' => $noticia->id, 'slug' => $noticia->slug]) }}" class="link-noticia text-white text-decoration-none fw-bold fs-6 fs-md-5 fs-lg-4">
                            {{ $noticia->titulo }}
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev" aria-label="Slide anterior">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next" aria-label="Próximo slide">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    @foreach($categorias as $categoria)

    @if($categoria->noticias->isNotEmpty())
    <div class="home-news titulo-categoria mb-2 mt-4 pt-2">
        <p class=" h3 fw-bolder nomeCategoria">
            <a href="{{ route('noticias.noticiasCategorias', $categoria->id) }}" class="categoria d-inline-flex align-items-center gap-2">
                {{ $categoria->nomeCategoria }}
                <svg viewBox="0 0 32 32" focusable="false" aria-hidden="true" width="22" height="15" fill="currentColor">
                    <path d="M21.6 14.3L5.5 31h6.4l14.6-15L11.9 1H5.5l16.1 16.7v-3.4z"></path>
                </svg>
            </a>
        </p>

        <div class="row">
            @foreach($categoria->noticias as $noticiaCategoria)
            <div class="col-md-4 mb-2">
                <div class="card h-100 bg-transparent border-0 shadow-none">
                    <img src="{{ asset('img/imgNoticias/' . $noticiaCategoria->imagem) }}" class="card-img-top img-capa" alt="{{ 'Imagem da notícia: ' . Str::limit($noticiaCategoria->titulo, 80) }}">
                    <div>
                        <h5 class="card-title pt-3 hover-underline">
                            <a href="{{ route('noticias.show', ['id' => $noticia->id, 'slug' => $noticia->slug]) }}">{{ $noticiaCategoria->titulo }}</a>
                        </h5>
                        <p class="card-text">
                            <small class="text-muted">Publicado dia {{ $noticiaCategoria->created_at->format('d/m/Y') }}</small>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endforeach
    @endif
</div>