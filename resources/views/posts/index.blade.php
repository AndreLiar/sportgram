<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Fil d'actualité</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto space-y-6">
        <!-- Filtres sport -->
        <div class="mb-6">
            <form method="GET" action="{{ route('posts.index') }}" class="flex flex-wrap items-center gap-3">
                <span class="text-sm font-semibold">Filtrer par sport :</span>
                <a href="{{ route('posts.index') }}"
                   class="text-blue-500 hover:underline {{ !$sport ? 'font-bold' : '' }}">
                    Tous
                </a>
                @foreach ($availableSports as $s)
                    <a href="{{ route('posts.index', ['filter' => $s]) }}"
                       class="text-blue-500 hover:underline {{ $sport === $s ? 'font-bold' : '' }}">
                        {{ ucfirst($s) }}
                    </a>
                @endforeach
            </form>
        </div>

        <!-- Liste des publications -->
        @forelse ($posts as $post)
            <div class="bg-white p-4 rounded shadow">
                <div class="flex items-center mb-2">
                    <span class="font-semibold">{{ $post->user->name }}</span>
                    <span class="ml-2 text-sm text-gray-500">| {{ $post->sport ?? 'Non défini' }}</span>
                </div>
                <img src="{{ asset('storage/' . $post->image_path) }}" class="w-full max-h-96 object-cover rounded mb-2">
                @if ($post->caption)
                    <p class="mb-1">{{ $post->caption }}</p>
                @endif
                @if ($post->hashtags)
                    <p class="text-blue-500 text-sm mt-1">{{ $post->hashtags }}</p>
                @endif
            </div>
        @empty
            <p>Aucune publication trouvée.</p>
        @endforelse

        <div>{{ $posts->links() }}</div>
    </div>
</x-app-layout>