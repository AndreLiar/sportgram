<x-guest-layout>
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="card shadow-sm p-4 w-100" style="max-width: 500px; animation: fadeIn 0.5s ease-out;">

            <!-- Logo & Heading -->
            <div class="text-center mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-sportgram.png') }}" alt="SportGram Logo" width="120">
                </a>
                <h2 class="h5 mt-3 fw-bold">Vérifie ton email</h2>
                <p class="text-muted small mb-0">
                    Merci de t'être inscrit ! Clique sur le lien envoyé par email pour activer ton compte.
                </p>
            </div>

            <!-- Status Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success text-center" role="alert">
                    Un nouveau lien de vérification a été envoyé à ton adresse email.
                </div>
            @endif

            <!-- Actions -->
            <div class="mt-4 d-flex justify-content-between">
                <!-- Resend Verification -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        {{ __('Renvoyer l\'email') }}
                    </button>
                </form>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">
                        {{ __('Déconnexion') }}
                    </button>
                </form>
            </div>

        </div>
    </div>

    <style>
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-guest-layout>
