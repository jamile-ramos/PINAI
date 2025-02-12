<section class="forum mt-4">
    <div class="table-responsive table-bordas">
        <table class="table table-hover table-striped">
            <thead class="forum-azul">
                <tr>
                    <th class="text-center">Tópicos</th>
                    <th class="text-center">Postagens</th>
                    <th class="text-center">Última Atualização</th>
                </tr>
            </thead>
            <tbody>
                @if(!$topicos->isEmpty())
                @foreach($topicos as $topico)
                <tr>
                    <td>
                        <a href="{{ route('postagens.index', ['id' => $topico->id]) }}" class="fw-bold">
                            {{ $topico->titulo }}
                        </a>
                    </td>
                    <td class="text-center">
                        <span class="icon">💬</span> {{ $topico->postagens_count }}
                    </td>
                    <td class="text-center">
                        <span class="icon">📅</span> {{ $topico->created_at->format('d/m/Y H:i') }}
                    </td>
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