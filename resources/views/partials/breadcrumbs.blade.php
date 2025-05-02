@unless ($breadcrumbs->isEmpty())
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                @php
                    $titleFull = $breadcrumb->title;
                    $titleShort = Str::limit($titleFull, 40);
                @endphp

                @if (!is_null($breadcrumb->url) && !$loop->last)
                    <li class="breadcrumb-item text-primary fw-light">
                        <a href="{{ $breadcrumb->url }}" title="{{ $titleFull }}">
                            <span class="visually-hidden">Ir para: </span>{{ $titleShort }}
                        </a>
                    </li>
                @else
                    <li class="breadcrumb-item active" aria-current="page" title="{{ $titleFull }}">
                        <span class="visually-hidden">Você está em: </span>{{ $titleShort }}
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endunless
