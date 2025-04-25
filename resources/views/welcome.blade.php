<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportGram – Révèle ton talent</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Animate via AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
</head>
<body class="bg-light text-dark">

    <!-- Header -->
<header class="container py-3 d-flex justify-content-between align-items-center">
    <!-- Logo à gauche -->
    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
        <img src="{{ asset('images/logo-sportgram.png') }}" alt="SportGram Logo" width="120" height="auto" class="me-3">
    </a>

    <!-- Liens à droite -->
    @if (Route::has('login'))
        <div class="d-flex gap-2">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-outline-dark btn-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Se connecter</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-dark btn-sm">S'inscrire</a>
                @endif
            @endauth
        </div>
    @endif
</header>


    <!-- Hero -->
    <main class="container py-5 text-center">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-up">
                <h1 class="display-5 fw-bold">Bienvenue sur <span class="text-danger">SportGram</span> 🏅</h1>
                <p class="lead text-secondary my-3">
                    La première plateforme sociale pour les athlètes amateurs. Publie tes performances, connecte-toi, gagne en visibilité.
                </p>
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center mt-4">
                    <a href="{{ url('/register') }}" class="btn btn-danger btn-lg px-4">Créer un compte</a>
                    <a href="{{ url('/feed') }}" class="btn btn-outline-dark btn-lg px-4">Voir les talents</a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="https://img.freepik.com/photos-gratuite/groupe-personnes-actives-cours-zumba_23-2149074929.jpg?w=740" class="img-fluid rounded shadow" alt="Illustration athlète">
            </div>
        </div>

        <!-- Features -->
        <section class="mt-5">
            <div class="row gy-4">
                <div class="col-md-4" data-aos="zoom-in">
                    <div class="p-3 border rounded h-100">
                        <h5>📸 Partage ton talent</h5>
                        <p class="text-muted">Publie tes photos et vidéos avec des légendes optimisées par IA.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="p-3 border rounded h-100">
                        <h5>🤝 Développe ton réseau</h5>
                        <p class="text-muted">Suis des athlètes, crée ton cercle sportif et reçois du soutien.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="p-3 border rounded h-100">
                        <h5>🧠 IA à ton service</h5>
                        <p class="text-muted">Laisse notre assistant IA t’aider à briller avec des publications engageantes.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Témoignages -->
        <section class="mt-5">
            <h2 class="mb-4" data-aos="fade-up">Ils nous font confiance</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card h-100">
                        <div class="card-body">
                            <p class="card-text">« Grâce à SportGram, j’ai été repéré par un coach pro ! »</p>
                            <h6 class="card-subtitle text-muted mt-3">– Sarah, sprinteuse</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100">
                        <div class="card-body">
                            <p class="card-text">« La communauté est incroyable. Je me sens soutenu dans mes défis. »</p>
                            <h6 class="card-subtitle text-muted mt-3">– Lucas, footballeur amateur</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100">
                        <div class="card-body">
                            <p class="card-text">« L’IA m’a aidé à améliorer mes publications et gagner en visibilité. »</p>
                            <h6 class="card-subtitle text-muted mt-3">– Inès, gymnaste</h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Final -->
        <section class="mt-5 py-5 bg-danger bg-gradient text-white rounded" data-aos="fade-up">
            <h3 class="fw-bold">Rejoins la communauté SportGram dès aujourd’hui !</h3>
            <p class="mb-4">Exprime ton talent, booste ta visibilité et connecte-toi aux bonnes personnes.</p>
            <a href="{{ url('/register') }}" class="btn btn-light btn-lg">Je m'inscris maintenant</a>
        </section>

        <!-- Footer professionnel -->
        <footer class="mt-5 border-top pt-4 pb-3 text-center text-muted small">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h6>SportGram</h6>
                        <p>La plateforme des athlètes passionnés.</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h6>Navigation</h6>
                        <ul class="list-unstyled">
                            <li><a href="{{ url('/feed') }}" class="text-muted text-decoration-none">Découvrir</a></li>
                            <li><a href="{{ url('/register') }}" class="text-muted text-decoration-none">S’inscrire</a></li>
                            <li><a href="{{ url('/login') }}" class="text-muted text-decoration-none">Connexion</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h6>Suivez-nous</h6>
                        <a href="#" class="text-muted me-2">Instagram</a>
                        <a href="#" class="text-muted me-2">TikTok</a>
                        <a href="#" class="text-muted">LinkedIn</a>
                    </div>
                </div>
                <div class="text-center mt-3">
                    &copy; {{ now()->year }} SportGram – Tous droits réservés.
                </div>
            </div>
        </footer>
    </main>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>AOS.init();</script>
</body>
</html>
