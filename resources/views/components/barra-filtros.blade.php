@props(['links' => [], 'actions' => []])

<div class="tab-buttons">
    <form action="/" method="GET" class="search-form" style="display: none;">
        <div class="search-container">
            <i class="fas fa-search mr-2"></i>
            <input type="text" class="search-input" name="query" placeholder="Pesquisar..." value="{{ request('query') }}" />
        </div>
    </form>

    <!-- Select para telas menores -->
    <div class="select-btn">
        <div class="select-option">Visão geral</div>
        <i class="dropdown-icon fas fa-chevron-down"></i>
        <div class="dropdown-select close-drop">
            @foreach($links as $link)
            <button
                class="option-btn"
                content-id="{{ $link['content-id'] ?? '' }}"
                data-tipo="{{ $link['data-tipo'] ?? '' }}">
                {{ $link['nomeAba'] ?? ''}}
            </button>
            @endforeach
            <div class="line-button"></div>
            <div class="btns-select">
                @foreach($actions as $action)
                <button
                    data-url=" {{ $action['data-url'] ?? ''}} "
                    class="option-add btn {{ $action['classBtn'] ?? ''}}"
                    content-id="{{ $action['content-id'] ?? ''}}">
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
            data-tipo="{{ $link['data-tipo'] ?? '' }}">
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
            content-id="{{ $action['content-id'] ?? ''}}">
            {{ $action['nomeButton'] ?? ''}}
        </button>
        @endforeach

        <div class="botao-pesquisar">
            <a href="javascript:void(0);" class="search-icon"><i class="fas fa-search mr-2"></i></a>
            <a href="javascript:void(0);" class="close-search" style="display: none;"><i class="fas fa-times mr-2"></i></a>
        </div>
    </div>
</div>