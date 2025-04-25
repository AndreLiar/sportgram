@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Profile Top Section -->
            <div class="d-flex flex-column align-items-center text-center mb-4">
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle border mb-3" width="120" height="120" alt="Avatar">
                @else
                    <img src="https://via.placeholder.com/120" class="rounded-circle border mb-3" alt="Avatar">
                @endif

                <h3 class="mb-0">{{ $user->name }}</h3>
                <p class="text-muted small">{{ $user->sport ?? 'Sport non défini' }}</p>

                @auth
                    @if (auth()->id() !== $user->id)
                        <!-- Follow/Unfollow Button for other users -->
                        <form method="POST" action="{{ route('users.follow', $user) }}" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ auth()->user()->isFollowing($user) ? 'btn-outline-danger' : 'btn-outline-primary' }}">
                                {{ auth()->user()->isFollowing($user) ? 'Ne plus suivre' : 'Suivre' }}
                            </button>
                        </form>
                    @else
                        <!-- Edit Profile Button if it's the same user -->
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-secondary mt-2">
                            ✏️ Modifier mon profil
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Stats Row -->
            <div class="d-flex justify-content-around mb-3 border-top pt-3">
                <div class="text-center">
                    <div class="fw-bold">{{ $user->posts->count() }}</div>
                    <small class="text-muted">Posts</small>
                </div>
                <div class="text-center">
                    <div class="fw-bold">{{ $user->followers()->count() }}</div>
                    <small class="text-muted">Abonnés</small>
                </div>
                <div class="text-center">
                    <div class="fw-bold">{{ $user->following()->count() }}</div>
                    <small class="text-muted">Suivis</small>
                </div>
            </div>

            <!-- Bio + Details -->
            <div class="mb-4 text-center small text-muted">
                <p class="mb-1">{{ $user->bio ?? 'Aucune bio renseignée.' }}</p>
                <p class="mb-0"><strong>Email :</strong> {{ $user->email }}</p>
                <p class="mb-0"><strong>Localisation :</strong> {{ $user->localisation ?? '-' }}</p>
                <p class="mb-0"><strong>Niveau :</strong> {{ $user->level ?? '-' }}</p>
            </div>

            <!-- Post Grid -->
            <div class="border-top pt-4">
                @if ($user->posts->isEmpty())
                    <p class="text-center text-muted">Aucune publication pour le moment.</p>
                @else
                    <div class="row g-2">
                        @foreach ($user->posts as $post)
                            <div class="col-4">
                                <div class="ratio ratio-1x1 rounded overflow-hidden">
                                    <img src="{{ asset('storage/' . $post->image_path) }}" class="w-100 h-100 object-fit-cover" alt="Post">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
