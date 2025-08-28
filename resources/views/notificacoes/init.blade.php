<div class="notif-center">
    @forelse($notificacoes as $n)
    <a href="{{ route('notificacoes.ler', ['id' => $n->id]) }}">
        <div class="notif-icon {{ $n->data['badgeClass'] ?? 'notif-primary' }}">
            <i class="{{ $n->data['icon'] ?? 'fas fa-bell' }}"></i>
        </div>
        <div class="notif-content">
            <span class="block">{{ $n->data['title'] ?? 'Nova notificação' }}</span>
            <span class="time">{{ $n->created_at->diffForHumans() }}</span>
        </div>
    </a>
    @empty
    <div class="p-2 text-center text-muted">Nenhuma notificação</div>
    @endforelse
</div>