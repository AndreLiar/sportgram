<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Fil d'actualité</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto space-y-6">
        <!-- Filtres -->
        <div class="mb-6">
            <form method="GET" action="{{ route('posts.index') }}" class="flex flex-wrap items-center gap-3">
                <span class="text-sm font-semibold">Filtrer :</span>
                <a href="{{ route('posts.index') }}"
                   class="{{ (!$sport && !request('following')) ? 'font-bold text-blue-600' : 'text-blue-500' }}">
                    Tous
                </a>
                <a href="{{ route('posts.index', ['following' => true]) }}"
                   class="{{ request('following') ? 'font-bold text-blue-600' : 'text-blue-500' }}">
                    Publications des suivis
                </a>
                @foreach ($availableSports as $s)
                    <a href="{{ route('posts.index', ['filter' => $s]) }}"
                       class="{{ $sport === $s ? 'font-bold text-blue-600' : 'text-blue-500' }}">
                        {{ ucfirst($s) }}
                    </a>
                @endforeach
            </form>
        </div>

        <!-- Suggestions -->
        @if (isset($suggestions) && $suggestions->count())
            <div class="bg-white shadow rounded p-4 mb-6">
                <h3 class="text-sm font-semibold mb-3">🔍 Suggestions à suivre</h3>
                <ul class="space-y-2">
                    @foreach ($suggestions as $suggested)
                        <li class="flex items-center justify-between">
                            <a href="{{ route('profile.show', $suggested) }}" class="text-blue-600 hover:underline">
                                {{ $suggested->name }}
                            </a>
                            <form method="POST" action="{{ route('users.follow', $suggested) }}">
                                @csrf
                                <button class="text-xs bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                    Suivre
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Publications -->
        @forelse ($posts as $post)
            <div class="bg-white p-4 rounded shadow space-y-3">
                <!-- En-tête -->
                <div class="flex items-center justify-between">
                    <div>
                        <a href="{{ route('profile.show', $post->user) }}"
                           class="font-semibold text-blue-600 hover:underline">
                            {{ $post->user->name }}
                        </a>
                        <span class="ml-2 text-sm text-gray-500">| {{ $post->sport ?? 'Non défini' }}</span>
                    </div>
                </div>

                <!-- Image -->
                <img src="{{ asset('storage/' . $post->image_path) }}"
                     class="w-full max-h-96 object-cover rounded mb-2">

                <!-- Légende -->
                @if ($post->caption)
                    <p class="mb-1">{{ $post->caption }}</p>
                @endif

                <!-- Hashtags -->
                @if ($post->hashtags)
                    <p class="text-blue-500 text-sm">{{ $post->hashtags }}</p>
                @endif

                <!-- Like AJAX -->
                <div class="flex items-center gap-3">
                    <button type="button"
                            data-post-id="{{ $post->id }}"
                            class="like-button text-sm text-red-500 hover:underline">
                        ❤️ <span class="like-count">{{ $post->likes->count() }}</span>
                        Like{{ $post->likes->count() > 1 ? 's' : '' }}
                    </button>
                </div>

                <!-- Commentaires -->
                <div class="mt-3 space-y-2">
                    <p class="font-semibold text-sm text-gray-700">💬 Commentaires :</p>
                    <div id="comments-{{ $post->id }}" class="space-y-1">
                        @foreach ($post->comments as $comment)
                            <div class="text-sm text-gray-800">
                                <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                            </div>
                        @endforeach
                    </div>

                    <!-- Formulaire AJAX -->
                    <form method="POST"
                          action="{{ route('posts.comments', $post) }}"
                          class="mt-2 comment-form"
                          data-post-id="{{ $post->id }}">
                        @csrf
                        <input type="text"
                               name="content"
                               placeholder="Ajouter un commentaire..."
                               class="w-full border rounded px-3 py-1 text-sm"
                               required>
                    </form>
                </div>
            </div>
        @empty
            <p>Aucune publication trouvée.</p>
        @endforelse

        <!-- Pagination -->
        <div>{{ $posts->links() }}</div>
    </div>

    <!-- Scripts -->
    @push('scripts')
    <script>
        // AJAX Like
        document.querySelectorAll('.like-button').forEach(button => {
            button.addEventListener('click', async function () {
                const postId = this.dataset.postId;
                const response = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                if (data && typeof data.count !== 'undefined') {
                    this.querySelector('.like-count').innerText = data.count;
                }
            });
        });

        // AJAX Commentaire
        document.querySelectorAll('.comment-form').forEach(form => {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                const postId = this.dataset.postId;
                const input = this.querySelector('input[name="content"]');
                const content = input.value;
                const response = await fetch(`/posts/${postId}/comments`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ content })
                });
                const data = await response.json();
                if (data.success) {
                    const commentsDiv = document.getElementById(`comments-${postId}`);
                    const newComment = document.createElement('div');
                    newComment.classList.add('text-sm', 'text-gray-800');
                    newComment.innerHTML = `<strong>${data.user}:</strong> ${data.content}`;
                    commentsDiv.appendChild(newComment);
                    input.value = '';
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
