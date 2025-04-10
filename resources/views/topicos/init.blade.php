<section class="forum mt-4">
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

    <nav aria-label="Paginação">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Anterior</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active">
                <a class="page-link" href="#">2 <span class="visually-hidden"></span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Próximo</a>
            </li>
        </ul>
    </nav>
</section>