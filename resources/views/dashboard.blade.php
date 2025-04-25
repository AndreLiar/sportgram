@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">🏟️ Mon Espace Sportif</h2>

        <!-- Actions rapides -->
        <div class="bg-white shadow-sm rounded p-4 mb-4">
            <h4 class="mb-3">Actions rapides</h4>
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('posts.create') }}" class="btn btn-primary">📸 Créer une publication</a>
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">👤 Modifier mon profil</a>
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">📰 Voir le fil</a>
            </div>
        </div>

        <!-- Derniers posts -->
        <div class="bg-white shadow-sm rounded p-4">
            <h4 class="mb-3">Dernières publications</h4>

            @php
                $recentPosts = \App\Models\Post::with('user')->latest()->take(3)->get();
            @endphp

            @forelse ($recentPosts as $post)
                <div class="mb-4">
                    <div class="small text-muted mb-1">
                        <strong>{{ $post->user->name }}</strong>
                        <span class="ms-2">| {{ $post->sport ?? 'Sport non défini' }}</span>
                    </div>
                    <img src="{{ asset('storage/' . $post->image_path) }}" class="img-fluid rounded mb-2" style="max-height: 300px; object-fit: cover;">
                    <p>{{ Str::limit($post->caption, 100) }}</p>
                </div>
            @empty
                <p class="text-muted">Aucune publication récente.</p>
            @endforelse
        </div>
    </div>
@endsection
