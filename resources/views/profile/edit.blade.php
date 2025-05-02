@extends('layouts.app')

@section('title', 'PINAI - Plataforma Interativa de Núcleos de Acessibilidade e Inclusão')

@section('content')


<div class="py-12 edit-profile">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        {{ Breadcrumbs::render('editarPerfil')}}

        <!-- Exibindo erro de senha com o ErrorBag 'userDeletion' -->
        @if ($errors->userDeletion && $errors->userDeletion->first('password'))
        <div class="alert alert-danger mt-2">
            {{ $errors->userDeletion->first('password') }}
        </div>
        @endif

        @if (session('status') === 'profile-updated')
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="alert alert-success"
            role="alert">
            {{ __('Informação atualizada com sucesso!') }}
        </div>
        @endif


        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

@endsection