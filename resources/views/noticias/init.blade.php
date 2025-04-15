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
                    <img src="{{ asset('img/imgNoticias/' . $noticia->imagem) }}" class="d-block w-100" alt="Imagem da notícia">
                    <div class="carousel-caption d-md-block fw-bold">
                        <a href="{{ route('noticias.show', $noticia->id) }}" class="link-noticia">{{ $noticia->titulo }}</a>
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
    $noticiaCategoria = $categoria->noticias()->where('status', 'ativo')->latest()->first();
    @endphp

    @if($noticiaCategoria)
    <div class="home-news titulo-categoria">
        <h2 class="nomeCategoria"><a href="{{ route('noticias.noticiasCategorias', $categoria->id) }}">{{ $categoria->nomeCategoria }}</a></h2>
        <div class="card card-new mb-3" style="max-width: 98%;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('img/imgNoticias/' . $noticiaCategoria->imagem) }}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title title-new">
                            <a href="{{ route('noticias.show', $noticiaCategoria->id) }}">{{ $noticiaCategoria->titulo }}</a>
                        </h5>
                        <p class="card-text">{{ Str::limit($noticiaCategoria->subtitulo, 150) }}</p>
                        <p class="card-text"><small class="text-muted">Publicado dia {{ $noticiaCategoria->created_at->format('d/m/Y') }}</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach

</div>