@extends('layouts.app')

@section('title', 'Meu perfil')

@section('content')
<div class="container-abas" id="myProfile">
    {{ Breadcrumbs::render('myProfile') }}
    <header class="text-center py-3 mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold">Meu perfil</h1>
        </div>
    </header>
    <div class="row content-profile" id="container-profile">
        <div class="col-lg-4 col-xl-4 card-profile-all">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-profile">
                            <div class="user-icon-circle-profile">
                                <i class="fa fa-user fa-profile"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="fs-5 mb-0 fw-bold">{{ Auth::user()->name }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 cardMy">
                            <div class="card card-profile cardMyChild text-center">
                                <span class="mb-1 text-roxo"><i class="fas fa-newspaper"></i></span>
                                <p class="h5 fw-bold mb-0">{{ $myNoticias->count() }}</p>
                                <p class="text-small px-4 fw-bold">Notícias</p>
                            </div>
                        </div>
                        <div class="col-6 cardMy">
                            <div class="card card-profile cardMyChild text-center">
                                <span class="mb-1 text-roxo"><i class="fas fa-pencil-alt"></i></span>
                                <p class="h5 fw-bold mb-0">{{ $myPostagens->count() }}</p>
                                <p class="text-small px-4 fw-bold">Postagens</p>
                            </div>
                        </div>
                        <div class="col-6 cardMy">
                            <div class="card card-profile cardMyChild text-center">
                                <span class="mb-1 text-roxo"><i class="fas fa-file-alt"></i></span>
                                <p class="h5 fw-bold mb-0">{{ $myDocumentos->count() }}</p>
                                <p class="text-small fw-bold">Documentos</p>
                            </div>
                        </div>
                        <div class="col-6 cardMy">
                            <div class="card card-profile cardMyChild text-center">
                                <span class="mb-1 text-roxo"><i class="fas fa-tools"></i></span>
                                <p class="h5 fw-bold mb-0">{{ $mySolucoes->count() }}</p>
                                <p class="text-small fw-bold">Solucões</p>
                            </div>
                        </div>
                    </div>

                    <ul class="list-unstyled mt-2">
                        <li class="mb-3 d-flex align-items-center p-2 rounded bg-light">
                            <span class="me-3 text-primary fs-5"><i class="fas fa-envelope"></i></span>
                            <div>
                                <p class="mb-0 fw-bold text-dark">Email</p>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </div>
                        </li>

                        <li class="mb-3 d-flex align-items-center p-2 rounded bg-light">
                            <span class="me-3 text-primary fs-5"><i class="fas fa-university"></i></span>
                            <div>
                                <p class="mb-0 fw-bold text-dark">NAI</p>
                                <small class="text-muted">{{ Auth::user()->nai->nome }} - {{ Auth::user()->nai->siglaNai }}</small>
                            </div>
                        </li>

                        <li class="mb-3 d-flex align-items-center p-2 rounded bg-light">
                            <span class="me-3 text-primary fs-5"><i class="fas fa-id-badge"></i></span>
                            <div>
                                <p class="mb-0 fw-bold text-dark">Tipo de usuário</p>
                                <small class="text-muted">{{ Auth::user()->tipoUsuario }}</small>
                            </div>
                        </li>
                    </ul>

                    <div class="col-12 text-center">
                        <a class="btn btn-visualizar px-5" href="/profile">Editar</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xl-8 container-abas" id="abaProfile">
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
                    @if(request()->filled('query') && $abaAtiva === 'myNoticias')
                    <!-- MODO DE BUSCA ATIVA -->
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
                        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
                            Foram encontrados {{ $myNoticias->total() }} resultado{{ $myNoticias->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
                        </span>
                        <a href="{{ route('profile.index') }}?abaAtiva={{ request('abaAtiva') }}"
                            class="btn-limpar-filtro"
                            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
                            <i class="fas fa-times-circle" aria-hidden="true"></i>
                            Limpar Filtro
                        </a>
                    </div>
                    @endif
                    <div class="infos">
                        <div class="row row-cols-1 g-4">
                            @forelse($myNoticias as $noticia)
                            <div class="col card-not-home pb-0">
                                <div class="card border-0 bg-white shadow-none">
                                    <div class="row g-0 h-100">
                                        <div class="col-md-4">
                                            <div class="h-100 w-100 overflow-hidden">
                                                <img src="{{ $noticia->imagem ? asset('img/imgNoticias/' . $noticia->imagem) : asset('/img/noticia-sem-imagem.png') }}"
                                                    class="img-fluid w-100 h-100"
                                                    style="min-height: 200px; max-height: 300px; object-fit: cover;"
                                                    alt="{{ $noticia->titulo }}">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body d-flex flex-column h-100 bg-transparent p-4">
                                                <h2 class="fs-5card-title title-new mb-2">
                                                    <a href="{{ route('noticias.show', ['id' => $noticia->id, 'slug' => $noticia->slug]) }}" class="text-decoration-none text-dark" data-btn="noticias" aria-label="Abrir a notícia completa: {{ $noticia->titulo }}">
                                                        {{ $noticia->titulo }}
                                                    </a>
                                                </h2>

                                                <p class="card-text">{{ Str::limit($noticia->subtitulo, 150) }}</p>
                                                <p class="card-text mt-2"><small class="text-muted">Publicado dia {{ $noticia->created_at->format('d/m/Y') }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="card my-4 p-4 text-center border-0 shadow-md bg-light">
                                <div class="card-body">
                                    <h2 class="fs-5card-title text-primary">A busca não retornou resultados</h2>
                                    <p class="card-text text-muted">
                                        Não encontramos nenhuma notícia.
                                        <br>
                                    </p>
                                    <i class="fas fa-search-location fa-4x text-muted mt-3"></i>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- PAGINAÇÃO -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $myNoticias->appends(request()->except('myNoticias_page'))->links('vendor.pagination.bootstrap-5')  }}
                    </div>
                </div>

                <div class="content-link" id="myPostagens">

                    @if(request()->filled('query') && $abaAtiva === 'myPostagens')
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
                        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
                            Foram encontrados {{ $myPostagens->total() }} resultado{{ $myPostagens->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
                        </span>
                        <a href="{{ route('profile.index') }}?abaAtiva={{ request('abaAtiva') }}"
                            class="btn-limpar-filtro"
                            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
                            <i class="fas fa-times-circle" aria-hidden="true"></i>
                            Limpar Filtro
                        </a>
                    </div>
                    @endif
                    <div class="infos">
                        @forelse($myPostagens as $postagem)
                        <div class="post-card">
                            <div class="post-header border-bottom border-secondary pb-3">
                                <div class="post-author">
                                    <div class="user-icon-circle user-post">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <span>Postado por <strong>{{ $postagem->user->name }}</strong></span>
                                </div>
                                <span class="text-muted">{{ $postagem->created_at->format('d/m/Y') }}</span>
                            </div>

                            <div class="post-title">
                                <h2 class="fs-5">{{ $postagem->titulo }}</h2>
                            </div>
                            <div class="post-content border-bottom border-light pb-3">
                                {{ Str::limit($postagem->conteudo, 100, '...') }}
                            </div>
                            <div class="post-footer mt-2">
                                <a href="{{ route('postagens.show', ['id' => $postagem->id, 'slug' => $postagem->slug] )}}" class="btn btn-primary">Ver Postagem</a>
                                <span><i class="fa-regular fa-comment"></i> {{ $postagem->respostas_count }} respostas</span>
                            </div>
                        </div>
                        @empty
                        <div class="card my-4 p-4 text-center border-0 shadow-md bg-light">
                            <div class="card-body">
                                <h2 class="fs-5card-title text-primary">A busca não retornou resultados</h2>
                                <p class="card-text text-muted">
                                    Não encontramos nenhuma postagem.
                                    <br>
                                </p>
                                <i class="fas fa-search-location fa-4x text-muted mt-3"></i>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <!-- Paginação -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $myPostagens->appends(request()->except('myPostagensProfile_page'))->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>

                <div class="content-link" id="myDocs">
                    @if(request()->filled('query') && $abaAtiva === 'myDocumentos')
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
                        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
                            Foram encontrados {{ $mydocumentos->total() }} resultado{{ $mydocumentos->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
                        </span>
                        <a href="{{ route('profile.index') }}?abaAtiva={{ request('abaAtiva') }}"
                            class="btn-limpar-filtro"
                            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
                            <i class="fas fa-times-circle" aria-hidden="true"></i>
                            Limpar Filtro
                        </a>
                    </div>
                    @endif
                    <div class="infos">
                        <div class="row g-4">
                            @forelse($myDocumentos as $documento)
                            <div class="col-md-4 col-md-6">
                                <div class="card h-100 shadow rounded-4 border-0">
                                    <div class="card-body text-center d-flex flex-column justify-content-between">
                                        <div class="mb-3">
                                            <i class="fa fa-file-pdf fa-3x text-primary"></i>
                                        </div>
                                        <h2 class="fs-5card-title fw-semibold">{{ $documento->nomeArquivo }}</h2>
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
                            <div class="card my-4 p-4 text-center border-0 shadow-md bg-light">
                                <div class="card-body">
                                    <h2 class="fs-5card-title text-primary">A busca não retornou resultados</h2>
                                    <p class="card-text text-muted">
                                        Não encontramos nenhum documento.
                                        <br>
                                    </p>
                                    <i class="fas fa-search-location fa-4x text-muted mt-3"></i>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- Paginação -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $myDocumentos->appends(request()->except('myDocumentos_page'))->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>

                <div class="content-link" id="mySolucoes">
                    @if(request()->filled('query') && $abaAtiva === 'mySolucoes')
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
                        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
                            Foram encontrados {{ $mySolucoes->total() }} resultado{{ $mySolucoes->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
                        </span>
                        <a href="{{ route('profile.index') }}?abaAtiva={{ request('abaAtiva') }}"
                            class="btn-limpar-filtro"
                            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
                            <i class="fas fa-times-circle" aria-hidden="true"></i>
                            Limpar Filtro
                        </a>
                    </div>
                    @endif
                    <div class="infos">
                        @forelse($mySolucoes as $solucao)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-lg rounded-4">
                                <div class="card-body d-flex flex-column p-4">
                                    <h2 class="fs-5card-title text-primary fw-bold mb-3">{{ $solucao->titulo }}</h2>
                                    <p class="text-muted mb-2 small mb-4"><strong>Por:</strong> {{ $solucao->user->nai->siglaNai }} - {{ $solucao->user->nai->siglaInstituicao }}</p>
                                    <p class="card-text text-muted mb-4">{{ Str::limit($solucao->descricao, 120) }}</p>
                                    <div class="d-flex justify-content-between mt-auto">
                                        <div class="text-secondary">
                                            <strong>Público-Alvo:</strong>
                                            <ul class="list-unstyled mb-3">
                                                @foreach($solucao->publicosAlvo as $publico)
                                                <li>• {{ $publico->nome }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="{{ route('solucoes.show', ['id' => $solucao->id, 'slug' => $solucao->slug]) }}" class="btn btn-primary rounded-pill px-4 py-2 mt-2">
                                        Ver mais
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="card my-4 p-4 text-center border-0 shadow-md bg-light">
                            <div class="card-body">
                                <h2 class="fs-5card-title text-primary">A busca não retornou resultados</h2>
                                <p class="card-text text-muted">
                                    Não encontramos nenhuma solução.
                                    <br>
                                </p>
                                <i class="fas fa-search-location fa-4x text-muted mt-3"></i>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                <!-- Paginação -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $mySolucoes->appends(request()->except('mySolucoes_page'))->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>
</div>

@endsection