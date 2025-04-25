<x-guest-layout>
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow-sm p-4 w-100" style="max-width: 450px; animation: fadeIn 0.5s ease-out;">

            <!-- Logo & Title -->
            <div class="text-center mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-sportgram.png') }}" alt="SportGram Logo" width="120">
                </a>
                <h2 class="h5 mt-3 fw-bold">Réinitialiser le mot de passe</h2>
                <p class="text-muted small mb-0">
                    Choisis un nouveau mot de passe pour accéder à ton compte.
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="form-control mt-1" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                </div>

                <!-- New Password -->
                <div class="mb-3">
                    <x-input-label for="password" :value="__('Nouveau mot de passe')" />
                    <x-text-input id="password" class="form-control mt-1" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                </div>

                <!-- Confirm New Password -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirme ton mot de passe')" />
                    <x-text-input id="password_confirmation" class="form-control mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end">
                    <x-primary-button class="btn btn-danger">
                        {{ __('Réinitialiser') }}
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
