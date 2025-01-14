@props(['links' => [],'actionsMenor' => [], 'actions' => [], 'modals' => []])

<div class="bg-light">
    <div class="navbar navbar-light bg-light barra-filtros">
        <!-- Botões de filtros -->
        <div class="filtros">
            @foreach($links as $link)
            <a href="{{ $link['href'] }}" class="{{ $link['class'] ?? '' }}" data-tipo="{{ $link['tipo'] ?? '' }}">{{ $link['nome'] }}</a>
            @endforeach

        </div>

        <!-- Filtros como Select para telas menores -->
        <div class="filtros-select" id="filtrosSelect">
            <div class="selected-option">Todas</div>
            <div class="options hidden">
                @foreach($links as $link)
                <button type="button" class="option" data-value="{{ $link['data-value'] }}" data-tipo="{{ $link['tipo'] ?? '' }}">{{ $link['nome'] }}</button>
                @endforeach
                <div class="line-button"></div>

                @foreach($actionsMenor as $action)
                <button type="button" class="btn {{ $action['class'] }}" id="{{ $action['id'] }}">{{ $action['nome'] }}</button>
                @endforeach
            </div>
            <i class="dropdown-icon fas fa-chevron-down"></i>
        </div>


        <div class="ml-auto d-flex align-items-center barra-pesquisa">
            <!-- Campo de pesquisa inicialmente escondido -->
            <form action="/" method="GET" class="search-form" style="display: none;">
                <div class="search-container">
                    <i class="fas fa-search mr-2"></i>
                    <input type="text" class="search-input" name="query" placeholder="Pesquisar..." value="{{ request('query') }}" />
                </div>
            </form>

            <!-- Filtro para telas maiores-->
            <div class="button-hide">
                @foreach($actions as $action)
                <button type="button" class="btn {{ $action['class'] }}" id="{{ $action['id'] }}">{{ $action['nome'] }}</button>
                @endforeach
            </div>

            <!-- Modais necessários -->
            @foreach($modals as $modal)
            @include($modal['view'], $modal['data'] ?? [])
            @endforeach

            <!-- Ícone de pesquisa que ativa a barra de pesquisa -->
            <div class="botao-pesquisar">
                <a href="javascript:void(0);" class="search-icon"><i class="fas fa-search mr-2"></i></a>
                <a href="javascript:void(0);" class="close-search" style="display: none;"><i class="fas fa-times mr-2"></i></a>
            </div>

        </div>
    </div>