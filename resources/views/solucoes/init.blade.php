<div class="container p-0 m-0">
  <main class="container p-0 m-0">
    <div class="row">
      <!-- Soluções -->
      <section class="largura p-0 ml-3">
        @foreach($categorias as $categoria)
        @php
        $solucoes = $categoria->solucoes()->where('status', 'ativo')->take(2)->get();
        @endphp

        @if($solucoes->isNotEmpty())
        <div class="mb-4">
          <h2 class="nomeCategoria fw-bold mb-4">
            <a href="{{ route('solucoes.solucoesCategorias', $categoria->id) }}" class="d-inline-flex align-items-center gap-2">
              {{ $categoria->nomeCategoria }}
              <svg viewBox="0 0 32 32" focusable="false" aria-hidden="true" width="22" height="15" fill="currentColor">
                <path d="M21.6 14.3L5.5 31h6.4l14.6-15L11.9 1H5.5l16.1 16.7v-3.4z"></path>
              </svg>
            </a>
          </h2>

          @foreach($solucoes as $solucao)
          <div class="mb-4">
            <div class="card shadow-lg rounded-4 border-0 p-4">
              <div class="card-body p-4">
                <h4 class="card-title fw-semibold text-dark mb-3">{{ $solucao->titulo }}</h4>

                <p class="card-text text-muted mb-4">
                  {{ $solucao->descricao }}
                </p>

                <div class="row mb-2">
                  <div class="col-md-6 mb-2">
                    <strong class="text-secondary d-block">Público-Alvo:</strong>
                    <ul>
                      @foreach($solucao->publicosAlvo as $publico)
                      <li>• {{ $publico->nome }}</li>
                      @endforeach
                    </ul>
                  </div>
                  <div class="col-md-6">
                    <strong class="text-secondary d-block">Categoria:</strong>
                    <span>{{ $solucao->categoria->nomeCategoria }}</span>
                  </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted">Por NAI IFSP</small>
                  <a href="{{ route('solucoes.show', $solucao->id) }}" class="btn btn-primary rounded-pill px-4">Ver Mais</a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @endif
        @endforeach
      </section>
    </div>
  </main>
</div>