<x-guest-layout>
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow-sm p-4 w-100" style="max-width: 400px; animation: fadeIn 0.5s ease-out;">
            <!-- Logo -->
            <div class="text-center mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-sportgram.png') }}" alt="SportGram Logo" width="120">
                </a>
                <h2 class="h5 mt-3 fw-bold">Connexion à <span class="text-danger">SportGram</span></h2>
                <p class="text-muted small mb-0">Rejoins ton réseau sportif et révèle ton talent</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="form-control mt-1" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input id="password" class="form-control mt-1" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                        {{ __('Se souvenir de moi') }}
                    </label>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center">
                    @if (Route::has('password.request'))
                        <a class="small text-muted text-decoration-none" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    @endif

                    <x-primary-button class="btn btn-danger">
                        {{ __('Connexion') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-guest-layout>
