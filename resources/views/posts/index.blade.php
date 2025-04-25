@extends('layouts.app')

@section('content')
<div class="container py-5 max-w-5xl mx-auto">
    <h2 class="mb-4">📰 Fil d'actualité</h2>

    <form method="GET" action="{{ route('posts.index') }}" class="mb-4 d-flex flex-wrap gap-2 align-items-center">
        <strong>Filtrer :</strong>
        <a href="{{ route('posts.index') }}" class="{{ (!$sport && !request('following')) ? 'fw-bold text-primary' : 'text-muted' }}">Tous</a>
        <a href="{{ route('posts.index', ['following' => true]) }}" class="{{ request('following') ? 'fw-bold text-primary' : 'text-muted' }}">Suivis</a>
        @foreach ($availableSports as $s)
            <a href="{{ route('posts.index', ['filter' => $s]) }}" class="{{ $sport === $s ? 'fw-bold text-primary' : 'text-muted' }}">{{ ucfirst($s) }}</a>
        @endforeach
    </form>

    @if ($suggestions->isNotEmpty())
        <div class="alert alert-light border">
            <strong>Suggestions :</strong>
            <ul class="list-unstyled mt-2">
                @foreach ($suggestions as $suggested)
                    <li class="d-flex justify-content-between align-items-center mb-2">
                        <a href="{{ route('profile.show', $suggested) }}" class="text-primary">{{ $suggested->name }}</a>
                        <form method="POST" action="{{ route('users.follow', $suggested) }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary">Suivre</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @forelse ($posts as $post)
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('profile.show', $post->user) }}" class="fw-bold text-primary">{{ $post->user->name }}</a>
                        <span class="text-muted ms-2">{{ $post->sport ?? 'Sport non défini' }}</span>
                    </div>
                </div>

                <img src="{{ asset('storage/' . $post->image_path) }}" 
     class="img-fluid rounded" 
     loading="lazy" 
     alt="Post image">

                @if ($post->caption)
                    <p>{{ $post->caption }}</p>
                @endif

                @if ($post->hashtags)
                    <p class="text-muted">{{ $post->hashtags }}</p>
                @endif

                <div>
                    <button class="btn btn-sm btn-outline-danger like-button" data-post-id="{{ $post->id }}">
                        ❤️ <span class="like-count">{{ $post->likes->count() }}</span> Like{{ $post->likes->count() > 1 ? 's' : '' }}
                    </button>
                </div>

                <!-- Commentaires -->
             <!-- Comment Toggle Button -->
<div class="mt-4">
    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#comments-{{ $post->id }}">
        💬 Voir les commentaires ({{ $post->comments->count() }})
    </button>

    <!-- Comment Section -->
    <div class="collapse mt-3" id="comments-{{ $post->id }}">
        <!-- Comment List -->
        <div class="mb-3">
            @foreach ($post->comments as $comment)
                <div class="d-flex align-items-start mb-2">
                    <span class="fw-bold me-2">{{ $comment->user->name }}</span>
                    <span class="text-muted small">{{ $comment->content }}</span>
                </div>
            @endforeach
        </div>

        <!-- Add Comment Form -->
        <form method="POST"
              action="{{ route('posts.comments', $post) }}"
              class="comment-form d-flex align-items-center border rounded px-2 py-1"
              data-post-id="{{ $post->id }}">
            @csrf
            <input type="text"
                   name="content"
                   class="form-control border-0 shadow-none"
                   placeholder="Ajouter un commentaire..."
                   required>
            <button type="submit" class="btn btn-outline-primary btn-sm ms-2">Envoyer</button>
        </form>
    </div>
</div>

            </div>
        </div>
    @empty
        <p>Aucune publication trouvée.</p>
    @endforelse

    {{ $posts->links() }}
</div>

@push('scripts')
<script>
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', async () => {
            const postId = button.dataset.postId;
            const res = await fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
            const data = await res.json();
            if (data?.count !== undefined) {
                button.querySelector('.like-count').innerText = data.count;
            }
        });
    });

    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const postId = form.dataset.postId;
            const input = form.querySelector('input[name="content"]');
            const content = input.value;

            const res = await fetch(`/posts/${postId}/comments`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content })
            });

            const data = await res.json();
            if (data.success) {
                const commentsDiv = document.getElementById(`comments-${postId}`);
                const newComment = document.createElement('p');
                newComment.innerHTML = `<strong>${data.user}:</strong> ${data.content}`;
                commentsDiv.appendChild(newComment);
                input.value = '';
            }
        });
    });
</script>
@endpush
@endsection
