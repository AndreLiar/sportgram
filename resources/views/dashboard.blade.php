<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Espace Sportif') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Actions rapides -->
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Actions rapides</h3>
                <div class="flex gap-4 flex-wrap">
                    <a href="{{ route('posts.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">📸 Créer une publication</a>
                    <a href="{{ route('profile.edit') }}" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">👤 Modifier mon profil</a>
                    <a href="{{ route('posts.index') }}" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">📰 Voir le fil</a>
                </div>
            </div>

            <!-- Derniers posts -->
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Dernières publications</h3>

                @php
                    $recentPosts = \App\Models\Post::with('user')->latest()->take(3)->get();
                @endphp

                @foreach ($recentPosts as $post)
                    <div class="mb-4">
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <strong>{{ $post->user->name }}</strong>
                            <span class="ml-2 text-xs">| {{ $post->sport ?? 'Sport non défini' }}</span>
                        </div>
                        <img src="{{ asset('storage/' . $post->image_path) }}" class="w-full max-h-60 object-cover rounded">
                        <p class="mt-1 text-sm">{{ Str::limit($post->caption, 100) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
