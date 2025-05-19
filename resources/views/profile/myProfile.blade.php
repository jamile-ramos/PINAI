@extends('layouts.app')

@section('title', 'Meu perfil')

@section('content')
<div class="col mx-4">
    {{ Breadcrumbs::render('myProfile') }}
    <header class="text-center py-3 mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold">Meu perfil</h1>
        </div>
    </header>
    <div class="row content-profile" id="container-profile">
        <div class="col-lg-4 col-xl-3 card-profile-all">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-profile">
                            <div class="user-icon-circle-profile">
                                <i class="fa fa-user fa-profile"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0">{{ Auth::user()->name }}</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col cardMy">
                            <div class="card card-profile cardMyChild text-center">
                                <span class="mb-1 text-roxo"><i class="fas fa-newspaper"></i></span>
                                <h3 class="mb-0">{{ $myNoticias->count() }}</h3>
                                <p class="text-muted-small px-4">Notícias</p>
                            </div>
                        </div>
                        <div class="col cardMy">
                            <div class="card card-profile cardMyChild text-center">
                                <span class="mb-1 text-roxo"><i class="fas fa-pencil-alt"></i></span>
                                <h3 class="mb-0">{{ $myPostagens->count() }}</h3>
                                <p class="text-muted-small px-4">Postagens</p>
                            </div>
                        </div>
                        <div class="col cardMy">
                            <div class="card card-profile cardMyChild text-center">
                                <span class="mb-1 text-roxo"><i class="fas fa-file-alt"></i></span>
                                <h3 class="mb-0">{{ $myDocumentos->count() }}</h3>
                                <p class="text-muted-small">Documentos</p>
                            </div>
                        </div>
                        <div class="col cardMy">
                            <div class="card card-profile cardMyChild text-center">
                                <span class="mb-1 text-roxo"><i class="fas fa-tools"></i></span>
                                <h3 class="mb-0">{{ $mySolucoes->count() }}</h3>
                                <p class="text-muted-small">Solucões</p>
                            </div>
                        </div>
                    </div>

                    <ul class="card-profile__info">
                        <li><strong class="text-dark me-4">Email</strong> <span>{{ Auth::user()->email }}</span></li>
                    </ul>
                    <div class="col-12 text-center">
                        <a class="btn btn-visualizar px-5" href="/profile">Editar</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xl-9 container-abas" id="abaProfile">
            <!-- Barra de opções-->
            <x-barra-filtros
                :links="[
                ['content-id' => 'myNoticias', 'nomeAba' => 'Minhas noticias', 'classActive' => 'active', 'data-tipo' => 'noticias'],
                ['content-id' => 'myPostagens', 'nomeAba' => 'Minhas postagens', 'data-tipo' => 'postagens'],
                ['content-id' => 'myDocs', 'nomeAba' => 'Meus documentos', 'data-tipo' => 'documentos'],
                ['content-id' => 'mySolucoes', 'nomeAba' => 'Minhas soluções','data-tipo' => 'solucoes']
            ]" />

            <!-- Conteúdo das abas -->
            <div class="tab-contents">
                <div class="content-link show" id="myNoticias">
                    <div class="infos">
                        <div class="row row-cols-1 g-4">
                            @foreach($myNoticias as $noticia)
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
                                                    <a href="{{ route('noticias.show', $noticia->id) }}" class="text-decoration-none text-dark" data-btn="noticias" aria-label="Abrir a notícia completa: {{ $noticia->titulo }}">
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
                </div>

                <div class="content-link" id="myPostagens">
                    <div class="infos">
                        @forelse($myPostagens as $postagem)
                        <div class="card">
                            <div class="card-body p-4">
                                <!-- Tag de Tópico no canto superior direito -->
                                <div class="topic-tag position-absolute top-0 end-0 m-3 px-2 py-1 bg-primary text-white rounded">
                                    {{ $postagem->topico->titulo }}
                                </div>

                                <div class="d-flex align-items-center mb-2">
                                    <div class="user-icon-circle user-post user-post2">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="d-flex flex-column mb-2">{{ $postagem->user->name }} <small class="text-muted">{{ $postagem->created_at->format('d/m/Y H:i') }}</small></h5>
                                    </div>
                                </div>
                                <div class="media-text">
                                    <div class="main-post-title">{{ $postagem->titulo }}</div>
                                    <p>{{ $postagem->conteudo }}</p>
                                </div>
                                <div class="post-footer btn-padding">
                                    <a href="{{ route('postagens.show', $postagem->id )}}" class="btn btn-primary">Ver Respostas</a>
                                    <span><i class="fa-regular fa-comment"></i> {{ $postagem->respostas->count() }} respostas</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <h5 class="px-4">Nenhuma postagem encontrada!</h5>
                        @endforelse
                    </div>
                </div>

                <div class="content-link" id="myDocs">
                    <div class="infos">
                        <div class="row g-4">
                            @forelse($myDocumentos as $documento)
                            <div class="col-md-4 col-sm-6">
                                <div class="card h-100 shadow rounded-4 border-0">
                                    <div class="card-body text-center d-flex flex-column justify-content-between">
                                        <div class="mb-3">
                                            <i class="fa fa-file-pdf fa-3x text-primary"></i>
                                        </div>
                                        <h5 class="card-title fw-semibold">{{ $documento->titulo }}</h5>
                                        <p class="card-text text-muted small">{{ Str::limit($documento->descricao, 100) }}</p>
                                        <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}" target="_blank" class="btn btn-link text-wrap">
                                            <i class="fa fa-eye"></i> Visualizar
                                        </a>
                                        <a href="{{ asset('storage/' . $documento->caminhoArquivo) }}" download class="btn btn-primary text-wrap">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <h5 class="px-6">Nenhum documento encontrado!</h5>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="content-link" id="mySolucoes">
                    <div class="infos">
                        @foreach($mySolucoes as $solucao)
                        <div class="mb-4">
                            <div class="card shadow-lg rounded-4 border-0 p-4">
                                <div class="card-body p-4">
                                    <h4 class="card-title fw-semibold text-dark mb-3">{{ $solucao->titulo }}</h4>

                                    <p class="card-text text-muted mb-4">
                                        {{ $solucao->descricao }}
                                    </p>

                                    <div class="row mb-2">
                                        <div class="col-md-6 mb-2">
                                            <strong class="text-secondary d-block">Público-Alvo:</strong>
                                            <ul>
                                                @foreach($solucao->publicosAlvo as $publico)
                                                <li>• {{ $publico->nome }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <strong class="text-secondary d-block">Categoria:</strong>
                                            <span>{{ $solucao->categoria->nomeCategoria }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Por NAI IFSP</small>
                                        <a href="{{ route('solucoes.show', $solucao->id) }}" class="btn btn-primary rounded-pill px-4">Ver Mais</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>
</div>

@endsection