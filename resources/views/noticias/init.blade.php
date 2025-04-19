<div id="conteudo-categorias">
    <div class="bd-example">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($noticiasRecentes as $index => $noticia)
                <li data-target="#carouselExampleCaptions" data-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($noticiasRecentes as $index => $noticia)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="carousel-image-container position-relative">
                        <img src="{{ asset('img/imgNoticias/' . $noticia->imagem) }}" class="d-block w-100" alt="Imagem da notícia">
                        <!-- Sombreado aplicado com gradiente -->
                        <div class="carousel-overlay position-absolute top-0 start-0 w-100 h-100"></div>
                    </div>
                    <div class="carousel-caption d-md-block position-absolute bottom-0 start-0 end-0 p-3">
                        <a href="{{ route('noticias.show', $noticia->id) }}" class="link-noticia text-white text-decoration-none fw-bold">
                            {{ $noticia->titulo }}
                        </a>
                    </div>
                </div>

                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    @foreach($categorias as $categoria)
    @php
    $noticiasCategorias = $categoria->noticias()->where('status', 'ativo')->take(3)->get();
    @endphp

    @if($noticiasCategorias->isNotEmpty())
    <div class="home-news titulo-categoria mb-4">
        <h2 class="nomeCategoria">
            <a href="{{ route('noticias.noticiasCategorias', $categoria->id) }}" class="d-inline-flex align-items-center gap-2">
                {{ $categoria->nomeCategoria }}
                <svg viewBox="0 0 32 32" focusable="false" aria-hidden="true" width="22" height="15" fill="currentColor">
                    <path d="M21.6 14.3L5.5 31h6.4l14.6-15L11.9 1H5.5l16.1 16.7v-3.4z"></path>
                </svg>
            </a>
        </h2>

        <div class="row">
            @foreach($noticiasCategorias as $noticiaCategoria)
            <div class="col-md-4 mb-3">
                <div class="card h-100 bg-transparent border-0 shadow-none">
                    <img src="{{ asset('img/imgNoticias/' . $noticiaCategoria->imagem) }}" class="card-img-top img-capa" alt="...">
                    <div class="card-body">
                        <h5 class="card-title pt-3 title-new">
                            <a href="{{ route('noticias.show', $noticiaCategoria->id) }}">{{ $noticiaCategoria->titulo }}</a>
                        </h5>
                        <p class="card-text">{{ Str::limit($noticiaCategoria->subtitulo, 150) }}</p>
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


</div>