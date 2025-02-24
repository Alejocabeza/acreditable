<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirect('/dashboard');
    }
}; ?>

<div
    class="min-h-screen bg-gradient-to-b from-blue-50 to-white flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
        <div class="text-center">
            <div class="flex justify-center">
                <a href='/'>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4" />
                        <path d="M3 5v14a2 2 0 0 0 2 2h16v-5" />
                        <path d="M18 12a2 2 0 0 0 0 4h4v-4Z" />
                    </svg>
                </a>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Bienvenido de nuevo
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Regístrate aquí
                </a>
            </p>
        </div>
        <form wire:submit="login" class="mt-8 space-y-6">
            @csrf
            <div class="rounded-md shadow-sm space-y-6">
                <div>
                    <label for="email" class="sr-only">
                        Correo electrónico
                    </label>
                    <input id="email" name="email" type="email" autocomplete="email" wire:model="form.email"
                        required
                        class="appearance-none rounded-lg relative block w-full pl-4 pr-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                        placeholder="Correo electrónico" value="{{ old('email') }}" />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>
                <div>
                    <label for="password" class="sr-only">
                        Contraseña
                    </label>
                    <input id="password" name="password" type="password" autocomplete="current-password"
                        wire:model="form.password" required
                        class="appearance-none rounded-lg relative block w-full pl-4 pr-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                        placeholder="Contraseña" />
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="block">
                    <label for="remember" class="inline-flex items-center">
                        <input wire:model="form.remember" id="remember" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">Recordarme</span>
                    </label>
                </div>
                <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Iniciar Sesión
                </button>
            </div>
        </form>
    </div>
</div>
