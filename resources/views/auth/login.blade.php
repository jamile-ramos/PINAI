<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />

            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between mt-6 mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-3 text-sm text-gray-600 dark:text-gray-400">{{ __('Lembre-me') }}</span>
            </label>

            @if (Route::has('password.request'))
            <a class="link-hover custom-focus text-sm text-indigo-600 dark:text-indigo-400" href="{{ route('password.request') }}">
                {{ __('Esqueceu sua senha?') }}
            </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="mb-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Entrar') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="text-center mt-4 link-hover">
            <a href="{{ route('register') }}" class="custom-focus text-sm text-gray-600 dark:text-gray-400 hover:underline">
                {{ __('Não tem uma conta? Cadastre-se') }}
            </a>
        </div>

</x-guest-layout>