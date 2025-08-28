<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('query');
        $abaAtiva = $request->input('abaAtiva');

        // Paginação por aba
        $pages = [
            'visaoNotificacoes' => $request->input('visaoNotificacoes_page', 1),
            'lidas' => $request->input('lidas_page', 1),
            'naoLidas' => $request->input('naoLidas_page', 1),
        ];

        // Todas
        $notificacoes = $this->buscarNotificacoes($user, $query, $pages['visaoNotificacoes'], null, 'visaoNotificacoes', $abaAtiva);

        // Lidas
        $lidas = $this->buscarNotificacoes($user, $query, $pages['lidas'], true, 'lidas', $abaAtiva);

        // Não Lidas
        $naoLidas = $this->buscarNotificacoes($user, $query, $pages['naoLidas'], false, 'naoLidas', $abaAtiva);

        return view('notificacoes.index', compact('notificacoes', 'lidas', 'naoLidas', 'query', 'abaAtiva'));
    }

    /**
     * Busca notificações com possibilidade de pesquisa, filtragem por read_at e paginação
     */
    private function buscarNotificacoes($user, $query, $pagina, $read = null, $aba, $abaAtiva)
    {
        $queryBuilder = DatabaseNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user));

        // Filtra por lidas/não lidas se $read não for nulo
        if ($read === true) {
            $queryBuilder->whereNotNull('read_at');
        } elseif ($read === false) {
            $queryBuilder->whereNull('read_at');
        }

        // Pesquisa no título, mensagem ou tipo
        if (!empty($query)) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('data->title', 'like', "%{$query}%")
                    ->orWhere('data->message', 'like', "%{$query}%")
                    ->orWhere('data->type', 'like', "%{$query}%");
            });
        }

        return $queryBuilder->orderByDesc('created_at')
            ->paginate(10, ['*'], "{$aba}_page", $pagina)
            ->appends(['query' => $query, 'abaAtiva' => $abaAtiva]);
    }

    /**
     * Retorna uma página vazia caso não existam resultados
     */
    public function paginaVazia($itensPorPagina, $pagina)
    {
        return new LengthAwarePaginator(
            collect([]),
            0,
            $itensPorPagina,
            $pagina,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }


    public function markAsRead($id)
    {
        $user = Auth::user();
        $notificacao = $user->notifications->firstWhere('id', $id);

        $tipo = $notificacao->data['type'] ?? null;

        if ($tipo) {
            // Se for agrupamento, marca todas do mesmo tipo
            $user->unreadNotifications
                ->where('data.type', $tipo)
                ->each(function ($notification) {
                    $notification->markAsRead();
                });
        } else {
            // Caso contrário, só a notificação individual
            $notificacao->markAsRead();
        }

        return redirect($notificacao->data['url'] ?? route('notificacoes.index'));
    }

    public function marcarLida($id)
    {
        $notificacao = Auth::user()->notifications->firstWhere('id', $id);
        if ($notificacao && is_null($notificacao->read_at)) {
            $notificacao->markAsRead();
        }
        return back();
    }

    public function marcarNaoLida($id)
    {
        $notificacao = Auth::user()->notifications->firstWhere('id', $id);
        if ($notificacao && !is_null($notificacao->read_at)) {
            $notificacao->update(['read_at' => null]);
        }
        return back();
    }

    public function destroy($id)
    {
        $user = Auth::user();

        // Busca a notificação diretamente pelo ID e pelo usuário
        $notificacao = DatabaseNotification::where('id', $id)
            ->where('notifiable_id', $user->id)
            ->first();

        if (!$notificacao) {
            return redirect()->back()->with('error', 'Notificação não encontrada.');
        }

        $notificacao->delete();

        return redirect()->back()->with('success', 'Notificação removida com sucesso.');
    }
}
