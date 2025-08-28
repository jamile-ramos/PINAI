@props(['links' => [], 'actions' => [], 'urlQuery' => url()->current()])

<div class="tab-buttons">
    <form action="{{ $urlQuery }}" method="GET" class="search-form" style="display: none;">
        <div class="search-container">
            <i class="fas fa-search mr-2"></i>
            <label for="search-query" class="sr-only">Pesquisar</label>
            <input type="hidden" name="abaAtiva" id="abaAtiva" value="">
            <input type="text" class="search-input" name="query" placeholder="Pesquisar..." value="{{ request('query') }}" />
        </div>
    </form>

    <!-- Select para telas menores -->
    <div class="select-btn"
        id="custom-combobox"
        role="combobox"
        aria-haspopup="listbox"
        aria-haspopup="listbox"
        aria-expanded="false"
        aria-controls="dropdown-options"
        aria-labelledby="selected-option"
        aria-activedescendant=""
        tabindex="0"
        aria-label="Selecionar aba de navegação">
        <div class="select-option" id="selected-option">Visão Geral</div>
        <i class="dropdown-icon fas fa-chevron-down"></i>

        <div class="dropdown-select close-drop"
            id="dropdown-options"
            role="listbox"
            tabindex="-1">
            @foreach($links as $link)
            <div
                role="option"
                id="option-{{ $loop->index }}"
                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                class="option-btn"
                content-id="{{ $link['content-id'] ?? '' }}"
                data-tipo="{{ $link['data-tipo'] ?? '' }}"
                tabindex="-1">
                {{ $link['nomeAba'] ?? ''}}
            </div>
            @endforeach
            <div class="line-button"></div>
            <div class="btns-select">
                @foreach($actions as $action)
                <button
                    data-url=" {{ $action['data-url'] ?? ''}} "
                    class="option-add btn {{ $action['classBtn'] ?? ''}}"
                    content-id="{{ $action['content-id'] ?? ''}}"
                    aria-label="{{ $action['nomeButton'] ?? 'ação'}}">
                    {{ $action['nomeButton'] ?? ''}}
                </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Link da aba para telas maiores -->
    <div role="tablist" aria-label="Navegação de abas">
        @foreach($links as $index => $link)
        <button
            id="tab-{{ $index }}"
            role="tab"
            aria-selected="{{ isset($link['classActive']) && $link['classActive'] === 'active' ? 'true' : 'false' }}"
            aria-controls="panel-1"
            class="tab-btn {{ $link['classActive'] ?? ''}}"
            content-id="{{ $link['content-id'] ?? ''}}"
            data-tipo="{{ $link['data-tipo'] ?? '' }}"
            aria-label="{{ $link['nomeAba'] ?? ''}}">
            {{ $link['nomeAba'] ?? ''}}
        </button>
        @endforeach
    </div>

    <!-- Botões para telas maiores -->
    <div class="add">
        @foreach($actions as $action)
        <button
            data-url=" {{ $action['data-url'] ?? ''}} "
            class="add-btn btn {{ $action['classBtn'] ?? ''}}"
            content-id="{{ $action['content-id'] ?? ''}}"
            aria-label="{{ $action['nomeButton'] ?? ''}}">
            {{ $action['nomeButton'] ?? ''}}
        </button>
        @endforeach

        <div class="botao-pesquisar">
            <button class="search-icon" aria-label="Pesquisar">
                <i class="fas fa-search mr-2"></i>
            </button>
            <button class="close-search" style="display: none;" aria-label="Fechar busca">
                <i class="fas fa-times mr-2"></i>
            </button>
        </div>

    </div>
</div>