<section class="forum">
    <table>
        <thead>
            <tr>
                <th>Tópicos</th>
                <th>Respostas</th>
                <th>Última Atualização</th>
            </tr>
        </thead>
        <tbody>
            @if(!$topicos->isEmpty()) 
                @foreach($topicos as $topico)
                <tr>
                    <td>
                        <a href="topic.html">{{ $topico->titulo }}</a><br>
                    </td>
                    <td><span class="icon">💬</span> 325</td>
                    <td><span class="icon">📅</span> {{ $topico->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            @else
                <tr><td colspan="3">Nenhum tópico encontrado!</td></tr>
            @endif
        </tbody>
    </table>
    <nav aria-label="...">
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active">
                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</section>
