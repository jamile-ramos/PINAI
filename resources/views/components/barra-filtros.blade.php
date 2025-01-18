@props(['links' => [], 'actions' => [], 'modals' => []])

<div class="bg-light">
    <div class="navbar navbar-light bg-light barra-filtros">
        <!-- Botões de filtros -->
        <div class="filtros">
            @foreach($links as $link)
            <a href="{{ $link['href'] }}"
                class="{{ $link['class'] ?? '' }}"
                data-value="{{ $link['data-value'] ?? '' }}"
                data-model="{{ $link['data-model'] ?? '' }}"
                data-tipo="{{ $link['data-tipo'] ?? '' }}"
                data-user="{{ $link['data-user'] ?? '' }}">
                {{ $link['nome'] }}
            </a>
            @endforeach
        </div>

        <!-- Filtros como Select para telas menores -->
        <div class="filtros-select" id="filtrosSelect">
            <div class="selected-option">Todas</div>
            <div class="options hidden">
                @foreach($links as $link)
                <button type="button" class="option {{ $link['class'] ?? '' }}"
                    data-value="{{ $link['data-value'] ?? '' }}"
                    data-model="{{ $link['data-model'] ?? '' }}"
                    data-tipo="{{ $link['data-tipo'] ?? '' }}"
                    data-user="{{ $link['data-user'] ?? '' }}">
                    {{ $link['nome'] }}
                </button>
                @endforeach
                <div class="line-button"></div>

                @foreach($actions as $action)
                <a href="{{ $action['href'] ?? ''}}" 
                data-toggle = "{{ $action['data-toggle'] ?? ''}}"
                data-target = "{{ $action['data-target'] ?? ''}}"
                type="button" 
                class="btn {{ $action['class'] }}" >
                {{ $action['nome'] }}</a>
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
                <a href="{{ $action['href'] ?? ''}}" 
                type="button" 
                data-toggle = "{{ $action['data-toggle'] ?? ''}}"
                data-target = "{{ $action['data-target'] ?? ''}}"
                class="btn {{ $action['class'] }}"         >
                {{ $action['nome'] }}</a>
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