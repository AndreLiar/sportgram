<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Nouvelle Publication</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Image -->
            <div>
                <label for="image">Image</label>
                <input type="file" name="image" required>
            </div>

            <!-- Caption -->
            <div>
                <label for="caption">Ta légende</label>
                <textarea name="caption" rows="3" class="w-full border-gray-300">{{ old('caption') }}</textarea>
            </div>

            <!-- Hashtags -->
            <div>
                <label for="hashtags">Tes hashtags</label>
                <input type="text" name="hashtags" class="w-full border-gray-300" value="{{ old('hashtags') }}">
            </div>

            <!-- Sport -->
            <div>
                <label for="sport">Sport</label>
                <input type="text" name="sport" class="w-full border-gray-300" value="{{ old('sport') }}">
            </div>

            <x-primary-button>Prévisualiser avec IA</x-primary-button>
        </form>
    </div>
</x-app-layout>
