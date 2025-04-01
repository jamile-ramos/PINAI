@extends('layouts.app')

@section('title', 'Meu perfil')

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
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
                                    <h3 class="mb-0">263</h3>
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
            <div class="col-lg-8 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <div class="media media-reply">
                            <img class="mr-3 circle-rounded" src="images/avatar/2.jpg" width="50" height="50" alt="Generic placeholder image">
                            <div class="media-body">
                                <div class="d-sm-flex justify-content-between mb-2">
                                    <h5 class="mb-sm-0">Milan Gbah <small class="text-muted ml-3">about 3 days ago</small></h5>
                                    <div class="media-reply__link">
                                        <button class="btn btn-transparent p-0 mr-3"><i class="fa fa-thumbs-up"></i></button>
                                        <button class="btn btn-transparent p-0 mr-3"><i class="fa fa-thumbs-down"></i></button>
                                        <button class="btn btn-transparent text-dark font-weight-bold p-0 ml-2">Reply</button>
                                    </div>
                                </div>

                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                                <ul>
                                    <li class="d-inline-block"><img class="rounded" width="60" height="60" src="images/blog/2.jpg" alt=""></li>
                                    <li class="d-inline-block"><img class="rounded" width="60" height="60" src="images/blog/3.jpg" alt=""></li>
                                    <li class="d-inline-block"><img class="rounded" width="60" height="60" src="images/blog/4.jpg" alt=""></li>
                                    <li class="d-inline-block"><img class="rounded" width="60" height="60" src="images/blog/1.jpg" alt=""></li>
                                </ul>

                                <div class="media mt-3">
                                    <img class="mr-3 circle-rounded circle-rounded" src="images/avatar/4.jpg" width="50" height="50" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <div class="d-sm-flex justify-content-between mb-2">
                                            <h5 class="mb-sm-0">Milan Gbah <small class="text-muted ml-3">about 3 days ago</small></h5>
                                            <div class="media-reply__link">
                                                <button class="btn btn-transparent p-0 mr-3"><i class="fa fa-thumbs-up"></i></button>
                                                <button class="btn btn-transparent p-0 mr-3"><i class="fa fa-thumbs-down"></i></button>
                                                <button class="btn btn-transparent p-0 ml-3 font-weight-bold">Reply</button>
                                            </div>
                                        </div>
                                        <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="media media-reply">
                            <img class="mr-3 circle-rounded" src="images/avatar/2.jpg" width="50" height="50" alt="Generic placeholder image">
                            <div class="media-body">
                                <div class="d-sm-flex justify-content-between mb-2">
                                    <h5 class="mb-sm-0">Milan Gbah <small class="text-muted ml-3">about 3 days ago</small></h5>
                                    <div class="media-reply__link">
                                        <button class="btn btn-transparent p-0 mr-3"><i class="fa fa-thumbs-up"></i></button>
                                        <button class="btn btn-transparent p-0 mr-3"><i class="fa fa-thumbs-down"></i></button>
                                        <button class="btn btn-transparent p-0 ml-3 font-weight-bold">Reply</button>
                                    </div>
                                </div>

                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                            </div>
                        </div>

                        <div class="media media-reply">
                            <img class="mr-3 circle-rounded" src="images/avatar/2.jpg" width="50" height="50" alt="Generic placeholder image">
                            <div class="media-body">
                                <div class="d-sm-flex justify-content-between mb-2">
                                    <h5 class="mb-sm-0">Milan Gbah <small class="text-muted ml-3">about 3 days ago</small></h5>
                                    <div class="media-reply__link">
                                        <button class="btn btn-transparent p-0 mr-3"><i class="fa fa-thumbs-up"></i></button>
                                        <button class="btn btn-transparent p-0 mr-3"><i class="fa fa-thumbs-down"></i></button>
                                        <button class="btn btn-transparent p-0 ml-3 font-weight-bold">Reply</button>
                                    </div>
                                </div>

                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
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