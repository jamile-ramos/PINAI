@extends('layouts.app')

@section('title', 'Meu perfil')

@section('content')
<div class="row content-profile">
    <div class="col-lg-4 col-xl-3">
        <div class="card cardProfile">
            <div class="card-body">
                <div class="media align-items-center mb-4">
                    <div class="avatar-profile">
                        <div class="user-icon-circle-profile">
                            <i class="fa fa-user fa-profile"></i>
                        </div>
                    </div>
                    <div class="media-body">
                        <h3 class="mb-0">{{ Auth::user()->name }}</h3>

                    </div>
                </div>

                <div class="row">
                    <div class="col cardMy">
                        <div class="card card-profile cardMyChild text-center">
                            <span class="mb-1 text-primary"><i class="fas fa-pencil-alt"></i></span>
                            <h3 class="mb-0">{{ $myPostagens->count() }}</h3>
                            <p class="text-muted-small px-4">Postagens</p>
                        </div>
                    </div>
                    <div class="col cardMy">
                        <div class="card card-profile cardMyChild text-center">
                            <span class="mb-1 text-warning"><i class="fas fa-file-alt"></i></span>
                            <h3 class="mb-0">263</h3>
                            <p class="text-muted-small">Documentos</p>
                        </div>
                    </div>
                </div>

                <ul class="card-profile__info">
                    <li><strong class="text-dark mr-4">Email</strong> <span>{{ Auth::user()->email }}</span></li>
                </ul>
                <div class="col-12 text-center">
                    <a class="btn btn-warning px-5" href="/profile">Editar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xl-9 container-abas" id="abaProfile">
        <!-- Barra de opções-->
        <x-barra-filtros
            :links="[
                ['content-id' => 'myPostagens', 'nomeAba' => 'Minhas postagens', 'classActive' => 'active', 'data-tipo' => 'postagens'],
                ['content-id' => 'myDocs', 'nomeAba' => 'Meus documentos', 'data-tipo' => 'postagens']
            ]" />

        <!-- Conteúdo das abas -->
        <div class="tab-contents">
            <div class="content-link show" id="myPostagens">
                <div class="infos">
                    @foreach($myPostagens as $postagem)
                    <div class="card">
                        <div class="card-body">
                            <div class="media media-reply">
                                <div class="post-author">
                                    <div class="user-icon-circle user-post user-post2">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-sm-flex justify-content-between mb-2 response-username">
                                        <h5 class="d-flex flex-column mb-2">{{ $postagem->user->name }} <small class="text-muted">{{ $postagem->created_at->format('d/m/Y H:i')}}</small></h5>
                                    </div>
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
                    @endforeach
                </div>
            </div>

            <div class="content-link" id="myDocs">
                <div class="infos">
                    <div class="card">
                        <div class="card-body">
                            <div class="media media-reply">
                                <div class="post-author">
                                    <div class="user-icon-circle user-post user-post2">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-sm-flex justify-content-between mb-2 response-username">
                                        <h5 class="d-flex flex-column mb-2">Testando <small class="text-muted">Testando</small></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="media-text">
                                <div class="main-post-title">Teste</div>
                                <p>Teste</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>

@endsection