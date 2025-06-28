<div class="table-responsive">
    @if(request('query') && $abaAtiva === 'all-users')
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded border border-secondary-subtle bg-light">
        <span class="result-count" aria-live="polite" aria-atomic="true" style="color:#333; font-weight:600; font-size: 1rem;">
            Foram encontrados {{ $usuarios->total() }} resultado{{ $usuarios->total() > 1 ? 's' : '' }} para: <span class="text-primary">"{{ $query }}"</span>
        </span>
        <a href="{{ route('painel.usuarios') }}?abaAtiva={{ request('abaAtiva') }}"
            class="btn-limpar-filtro"
            aria-label="Limpar filtro de pesquisa e exibir todos os usuários">
            <i class="fas fa-times-circle" aria-hidden="true"></i>
            Limpar Filtro
        </a>
    </div>
    @endif

    <table class="table table-hover table-striped">
        <thead class="forum-azul">
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>NAI</th>
                <th>Tipo de usuário</th>
                <th>Status</th>
                <th>Data de criação</th>
                <th style="width: 10%">Ação</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->nai?->siglaNai ?? 'Não selecionado' }}</td>
                <td>@if ($usuario->tipoUsuario == 'comum')
                    Comum
                    @elseif ($usuario->tipoUsuario == 'admin')
                    Admin
                    @elseif ($usuario->tipoUsuario == 'moderador')
                    Moderador
                    @endif
                </td>
                <td>{{ $usuario->status == 'ativo' ? 'Ativo' : 'Inativo' }}</td>
                <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="form-button-action">
                        <button type="button" class="btn btn-info d-inline btn-alterar"
                            data-id="{{ $usuario->id }}"
                            data-name="{{ $usuario->name }}"
                            data-email="{{ $usuario->email }}"
                            data-type="{{ $usuario->tipoUsuario }}"
                            data-nai="{{ $usuario->nai?->id ?? 'selecione'  }}"
                            aria-label="Editar Usuário">
                            Editar
                        </button>
                        <button type="button" class="btn toggle-status btn-status {{ $usuario->status == 'ativo' ? 'btn-danger' : 'btn-success' }}"
                            data-id="{{ $usuario->id }}"
                            data-status="{{ $usuario->status }}"
                            aria-label="{{ $usuario->status == 'ativo' ? 'Desabilitar' : 'Ativar' }} usuário">
                            {{ $usuario->status == 'ativo' ? 'Desabilitar' : 'Ativar' }}
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Nenhum usuário encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-3">
        {{ $usuarios->appends(request()->except('users_page'))->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Editar</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST" data-route="{{ route('painel.update', ':id') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="userId" name="userId">
                    <div class="form-group">
                        <label for="userName">Nome</label>
                        <input type="text" class="form-control" id="userName" name="userName">
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="userEmail">
                    </div>
                    <div class="form-group">
                        <label for="userNai">Núcleo de Acessibilidade e Inclusão (NAI)</label>
                        <select class="form-control" id="userNai" name="userNai">
                            <option value="selecione" selected disabled>Selecione um NAI...</option>
                            @foreach($nais as $nai)
                            <option value="{{ $nai->id }}">{{ $nai->siglaNai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userType">Tipo de Usuário</label>
                        <select class="form-control" id="userType" name="tipoUsuario">
                            <option value="comum">Comum</option>
                            <option value="admin">Admin</option>
                            <option value="moderador">Moderador</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Ativação/Desativação -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="confirmModalLabel">Confirmar Ação</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body body-confirmar">
                <div class="texto-confirmar">
                    <p>Tem certeza de que deseja desativar este usuário?</p>
                </div>
                <!-- Formulário para desativar o usuário -->
                <form id="confirmForm" data-route="{{ route('painel.updateStatus', ':id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" id="status">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="confirmActionBtn" class="btn">Desabilitar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>