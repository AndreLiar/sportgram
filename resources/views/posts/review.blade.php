<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Prévisualisation avec IA</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto space-y-6">
        <!-- Image preview -->
        <img src="{{ asset('storage/' . $imagePath) }}" class="w-full max-h-96 object-cover rounded">

        <!-- Formulaire de publication -->
        <form method="POST" action="{{ route('posts.finalize') }}">
            @csrf

            <input type="hidden" name="image_path" value="{{ $imagePath }}">
            <input type="hidden" name="sport" value="{{ $sport }}">

            <!-- Légende générée -->
            <div>
                <label for="caption" class="font-medium text-sm">✍️ Légende suggérée</label>
                <textarea name="caption" rows="3" class="w-full border-gray-300 rounded">{{ $caption }}</textarea>
            </div>

            <!-- Hashtags générés -->
            <div>
                <label for="hashtags" class="font-medium text-sm">🏷️ Hashtags suggérés</label>
                <input type="text" name="hashtags" class="w-full border-gray-300 rounded" value="{{ $hashtags }}">
            </div>

            <!-- Boutons -->
            <div class="flex items-center gap-4 mt-4">
                <x-primary-button>📤 Publier</x-primary-button>

                <button type="button" id="regen-btn" class="text-sm text-blue-600 hover:underline">
                    🔁 Regénérer avec IA
                </button>

                <span id="regen-loader" class="text-sm text-blue-500 hidden">
                    Génération en cours...
                </span>
            </div>
        </form>
    </div>

    <!-- Script AJAX pour régénération -->
    <script>
        const regenBtn = document.getElementById('regen-btn');
        const loader = document.getElementById('regen-loader');
        const captionTextarea = document.querySelector('textarea[name="caption"]');
        const hashtagsInput = document.querySelector('input[name="hashtags"]');

        regenBtn.addEventListener('click', async function () {
            loader.classList.remove('hidden');

            const response = await fetch('{{ route('posts.regenerateText') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    caption: captionTextarea.value,
                    hashtags: hashtagsInput.value,
                })
            });

            const data = await response.json();
            captionTextarea.value = data.caption;
            hashtagsInput.value = data.hashtags;

            loader.classList.add('hidden');
        });
    </script>
</x-app-layout>
