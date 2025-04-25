<x-guest-layout>
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow-sm p-4 w-100" style="max-width: 450px; animation: fadeIn 0.5s ease-out;">
            
            <!-- Logo + Header -->
            <div class="text-center mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-sportgram.png') }}" alt="SportGram Logo" width="120">
                </a>
                <h2 class="h5 mt-3 fw-bold">Inscription à <span class="text-danger">SportGram</span></h2>
                <p class="text-muted small mb-0">Crée ton compte et commence à partager ton talent</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <x-input-label for="name" :value="__('Nom complet')" />
                    <x-text-input id="name" class="form-control mt-1" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Adresse e-mail')" />
                    <x-text-input id="email" class="form-control mt-1" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input id="password" class="form-control mt-1" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                    <x-text-input id="password_confirmation" class="form-control mt-1" type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center">
                    <a class="small text-muted text-decoration-none" href="{{ route('login') }}">
                        {{ __('Déjà inscrit ? Connecte-toi') }}
                    </a>

                    <x-primary-button class="btn btn-danger">
                        {{ __('Créer mon compte') }}
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
