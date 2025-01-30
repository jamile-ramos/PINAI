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
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $noticia->titulo }}</h5>
                        <p>{{ Str::limit($noticia->descricao, 100) }}</p>
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

    <div class="home-news titulo-categoria">
        <h2>Categoria</h2>
        <div class="card card-new mb-3" style="max-width: 98%;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="img/blogpost.jpg" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title title-new">
                            <a href="#">Novos Avanços em Tecnologias Assistivas para Pessoas com Deficiência</a>
                        </h5>
                        <p class="card-text">Esta notícia pode destacar as inovações tecnológicas que estão melhorando a vida de pessoas com deficiência, como novos softwares de leitura de tela, dispositivos de navegação para deficientes visuais e avanços em aparelhos auditivos.</p>
                        <p class="card-text"><small class="text-muted">Publicado dia 12/09/2021</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>