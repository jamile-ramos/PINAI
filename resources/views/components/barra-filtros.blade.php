@props(['links' => [], 'actions' => [], 'modals' => []])

<div class="container-abas">
    <div class="tab-buttons">
        <form action="/" method="GET" class="search-form" style="display: none;">
            <div class="search-container">
                <i class="fas fa-search mr-2"></i>
                <input type="text" class="search-input" name="query" placeholder="Pesquisar..." value="{{ request('query') }}" />
            </div>
        </form>

        <!-- Link da aba para telas maiores -->
        @foreach($links as $link)
            <button class="tab-btn active" content-id="{{ $link['contentId'] }}">
                {{ $link['data-aba'] }}
            </button>
        @endforeach

        <!-- Botões para telas maiores -->
        <div class="add">
            @foreach($actions as $action)
                <button class="add-btn btn {{ $action['data-btn'] }}">
                    {{ $action['data-button'] }}
                </button>
            @endforeach

            <div class="botao-pesquisar">
                <a href="javascript:void(0);" class="search-icon"><i class="fas fa-search mr-2"></i></a>
                <a href="javascript:void(0);" class="close-search" style="display: none;"><i class="fas fa-times mr-2"></i></a>
            </div>
        </div>
    </div>

    <div class="tab-contents">
        <div class="content-link show" id="all">
            <div class="infos">
                <h1 class="content-title">
                    Home
                </h1>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis eaque eos cum voluptatibus repudiandae autem, voluptate ex dicta officiis odio illo magni, dolores quibusdam temporibus alias expedita eligendi et nam?</p>
            </div>
        </div>

        <div class="content-link" id="mys">
            <div class="infos">
                @include('noticias.minhasNoticias')
            </div>
        </div>

        <div class="content-link" id="categorias">
            <div class="infos">
                @include('noticias.categorias')
            </div>
        </div>
    </div>
</div>