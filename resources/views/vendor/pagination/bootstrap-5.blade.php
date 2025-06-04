@if ($paginator->hasPages())
    <nav aria-label="Paginação de resultados">
        <ul class="pagination justify-content-center">
            {{-- Botão Anterior --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-label="Página anterior desabilitada">Anterior</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Página anterior">Anterior</a>
                </li>
            @endif

            {{-- Páginas --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page" aria-label="Página atual, página {{ $page }}">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}" aria-label="Ir para a página {{ $page }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botão Próximo --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Próxima página">Próximo</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-label="Próxima página desabilitada">Próximo</span>
                </li>
            @endif
        </ul>

        {{-- Texto mostrando o intervalo --}}
        <div class="text-center mt-2">
            <p class="small text-muted mb-0">
                {!! __('Mostrando') !!}
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                {!! __('a') !!}
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                {!! __('de') !!}
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                {!! __('resultados') !!}
            </p>
        </div>
    </nav>
@endif
