<x-guest-layout>
    <!-- Session Status (opcional) -->
    @if (session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
    </div>
    @endif

    <!-- Alerta de erro geral -->
    @if (session('error'))
    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
        {{ session('error') }}
    </div>
    @endif
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nome -->
        <div>
            <x-input-label for="name" :value="__('Nome')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Nai -->
        <div class="mt-4">
            <x-input-label for="nai" :value="__('Núcleo de Acessibilidade e Inclusão')" />
            <select id="nai" name="nai" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                <option value="">Selecione uma opção</option>
                @foreach($nais as $nai)
                <option value="{{ $nai->id }}">{{ $nai->siglaNai}} - {{ $nai->siglaInstituicao }}</option>
                @endforeach
            </select>
        </div>

        <!-- Senha -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Senha -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar senha')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Botão Registrar -->
        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>

        <!-- Link para Login -->
        <div class="mt-4 text-center link-hover">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                {{ __('Já tem uma conta? Faça login.') }}
            </a>
        </div>
    </form>
</x-guest-layout>