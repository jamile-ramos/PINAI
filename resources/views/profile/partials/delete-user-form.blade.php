<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Excluir conta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Depois que sua conta for excluída, todos os seus recursos e dados serão excluídos permanentemente. Antes de excluir sua conta, baixe quaisquer dados ou informações que você deseja reter.') }}
        </p>
    </header>

    <!-- Botão para abrir o modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        {{ __('Excluir conta') }}
    </button>
    <!-- Modal de confirmação de exclusão -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">
                            {{ __('Tem certeza de que deseja excluir sua conta?') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Depois que sua conta for excluída, todos os seus recursos e dados serão excluídos permanentemente. Insira sua senha para confirmar que você deseja excluir sua conta permanentemente.') }}
                        </p>

                        <div class="mt-6">
                            <x-input-label for="password" value="{{ __('Senha') }}" class="sr-only" />
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control"
                                placeholder="{{ __('Senha') }}"
                                value="{{ old('password') }}"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-danger">
                            {{ __('Excluir conta') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
