<section class="forum">
    @if(request('query') && $abaAtiva === 'visaoTopicos')
    <div class="d-flex justify-content-between align-items-center mt-0 mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $topicos->total() }} resultado{{ $topicos->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('topicos.index') }}?abaAtiva={{ request('abaAtiva') }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @endif
    <div class="table-responsive table-bordas">
        <table class="table table-hover table-striped">
            <thead class="forum-azul">
                <tr>
                    <th>Tópicos</th>
                    <th>Postagens</th>
                    <th>Última Atualização</th>
                </tr>
            </thead>
            <tbody>
                @if(!$topicos->isEmpty())
                @foreach($topicos as $topico)
                <tr>
                    <td>
                        <a href="{{ route('postagens.index', ['idTopico' => $topico->id]) }}" class="fw-bold">
                            {{ $topico->titulo }}
                        </a>
                    </td>
                    <td>
                        <span class="icon">💬</span> {{ $topico->postagens_count }}
                    </td>
                    @if($topico->postagens->isNotEmpty())
                    <td>
                        <span class="icon">📅</span> {{$topico->postagens->first()->updated_at->format('d/m/Y H:i')}}
                    </td>
                    @endif
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="3" class="text-center text-muted">Nenhum tópico encontrado!</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-3">
        {{ $topicos->appends(request()->except('topicos_page'))->links('vendor.pagination.bootstrap-5')}}
    </div>

</section>