<div class="container">
  <main>
    @foreach($categorias as $categoria)
    @php
    $solucoes = $categoria->solucoes()->where('status', 'ativo')->take(2)->get();
    @endphp

    @if($solucoes->isNotEmpty())
    <div class="mb-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">
          <a href="{{ route('solucoes.solucoesCategorias', $categoria->id) }}" class="categoria text-decoration-none text-dark d-flex align-items-center gap-2">
            {{ $categoria->nomeCategoria }}
            <svg viewBox="0 0 32 32" width="22" height="15" fill="currentColor">
              <path d="M21.6 14.3L5.5 31h6.4l14.6-15L11.9 1H5.5l16.1 16.7v-3.4z" />
            </svg>
          </a>
        </h2>
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
    </div>
    @endif
    @endforeach
  </main>
</div>