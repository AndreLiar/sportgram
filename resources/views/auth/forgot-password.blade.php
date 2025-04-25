<x-guest-layout>
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow-sm p-4 w-100" style="max-width: 450px; animation: fadeIn 0.5s ease-out;">
            
            <!-- Logo & Intro -->
            <div class="text-center mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-sportgram.png') }}" alt="SportGram Logo" width="120">
                </a>
                <h2 class="h5 mt-3 fw-bold">Réinitialiser le mot de passe</h2>
                <p class="text-muted small mb-0">
                    Tu as oublié ton mot de passe ? Entre ton email pour recevoir un lien de réinitialisation.
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Adresse e-mail')" />
                    <x-text-input id="email" class="form-control mt-1" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end">
                    <x-primary-button class="btn btn-danger">
                        {{ __('Envoyer le lien') }}
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
