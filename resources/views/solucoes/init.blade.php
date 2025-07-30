<div class="container">
  <main>
    @if(request()->filled('query') && $abaAtiva === 'visaoSolucoes')
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
      <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
        Foram encontrados {{ $solucoes->total() }} resultado{{ $solucoes->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
      </span>
      <a href="{{ route('solucoes.index') }}?abaAtiva={{ request('abaAtiva') }}"
        class="btn-limpar-filtro"
        aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
        <i class="fas fa-times-circle" aria-hidden="true"></i>
        Limpar Filtro
      </a>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
      @foreach($solucoes as $solucao)
      <div class="col">
        <div class="card h-100 border-0 shadow-lg rounded-4">
          <div class="card-body d-flex flex-column p-4">
            <h5 class="card-title text-primary fw-bold mb-3">{{ $solucao->titulo }}</h5>
            <p class="text-muted mb-2 small mb-4"><strong>Por:</strong> {{ $solucao->user->nai->siglaNai }} - {{ $solucao->user->nai->siglaInstituicao }}</p>
            <p class="card-text text-muted mb-4">{{ Str::limit($solucao->descricao, 120) }}</p>
            <div class="d-flex justify-content-between mt-auto">
              <div class="text-secondary">
                <strong>Público-Alvo:</strong>
                <ul class="list-unstyled mb-3">
                  @foreach($solucao->publicosAlvo as $publico)
                  <li>• {{ $publico->nome }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
            <a href="{{ route('solucoes.show', $solucao->id) }}" class="btn btn-primary rounded-pill px-4 py-2 mt-2">
              Ver mais
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-3">
      {{ $solucoes->appends(request()->except('solucoes_page'))->links('vendor.pagination.bootstrap-5') }}
    </div>

    @else

    @foreach($categorias as $categoria)
    @if($categoria->solucoes->isNotEmpty())
    <div class="mb-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="h3 nomeCategoria fw-bold">
          <a href="{{ route('solucoes.solucoesCategorias', $categoria->id) }}" class="categoria text-decoration-none text-dark d-flex align-items-center gap-2">
            {{ $categoria->nomeCategoria }}
            <svg viewBox="0 0 32 32" width="22" height="15" fill="currentColor">
              <path d="M21.6 14.3L5.5 31h6.4l14.6-15L11.9 1H5.5l16.1 16.7v-3.4z" />
            </svg>
          </a>
        </p>
      </div>

      <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach($categoria->solucoes as $solucao)
        <div class="col">
          <div class="card h-100 border-0 shadow-lg rounded-4">
            <div class="card-body d-flex flex-column p-4">
              <h5 class="card-title text-primary fw-bold mb-3">{{ $solucao->titulo }}</h5>
              <p class="text-muted mb-2 small mb-4"><strong>Por:</strong> {{ $solucao->user->nai->siglaNai }} - {{ $solucao->user->nai->siglaInstituicao }}</p>
              <p class="card-text text-muted mb-4">{{ Str::limit($solucao->descricao, 120) }}</p>
              <div class="text-secondary">
                <strong class="d-block mb-2">Público-Alvo:</strong>
                <ul class="list-unstyled mb-1">
                  @foreach($solucao->publicosAlvo->take(5) as $publico)
                  <li>• {{ $publico->nome }}</li>
                  @endforeach
                </ul>
                @if($solucao->publicosAlvo->count() > 5)
                <small class="text-muted">
                  e mais {{ $solucao->publicosAlvo->count() - 5 }} público{{ $solucao->publicosAlvo->count() - 5 > 1 ? 's' : '' }} alvo(s)
                </small>
                @endif
              </div>

              <a href="{{ route('solucoes.show', $solucao->id) }}" class="btn btn-primary rounded-pill px-4 py-2 mt-2 mt-auto">
                Ver mais
              </a>

            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
    @endforeach
    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-3">
      {{ $categorias->appends(request()->except('visaoCategoriasSol_page'))->links('vendor.pagination.bootstrap-5') }}
    </div>

    @endif
  </main>
</div>