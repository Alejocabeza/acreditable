<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

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
                Únete a nosotros ahora
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Iniciar sesión
                </a>
            </p>
        </div>
        <form wire:submit="register" class="mt-8 space-y-6">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="name" class="sr-only">
                        Nombre
                    </label>
                    <input id="name" name="name" type="name" autocomplete="name" wire:model="form.name"
                        required
                        class="appearance-none rounded-lg relative block w-full pl-4 pr-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                        placeholder="Nombre" value="{{ old('name') }}" />
                    <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                </div>
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
                <div>
                    <label for="password_confirmation" class="sr-only">
                        Confirmar contraseña
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password_confirmation"
                        autocomplete="new-password" wire:model="form.password_confirmation" required
                        class="appearance-none rounded-lg relative block w-full pl-4 pr-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                        placeholder="Confirmar contraseña" />
                    <x-input-error :messages="$errors->get('form.password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Registrarse
                </button>
            </div>
        </form>
    </div>
</div>
