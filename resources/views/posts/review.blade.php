@extends('layouts.app')

@section('content')
<div class="container py-5 max-w-3xl mx-auto">
    <h2 class="mb-4">📸 Prévisualisation avec IA</h2>

    <img src="{{ asset('storage/' . $imagePath) }}" class="w-100 rounded mb-4" style="max-height: 500px; object-fit: cover;">

    <form method="POST" action="{{ route('posts.finalize') }}">
        @csrf

        <input type="hidden" name="image_path" value="{{ $imagePath }}">
        <input type="hidden" name="sport" value="{{ $sport }}">

        <div class="mb-3">
            <label class="form-label">✍️ Légende suggérée</label>
            <textarea name="caption" class="form-control" rows="3">{{ $caption }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">🏷️ Hashtags suggérés</label>
            <input type="text" name="hashtags" class="form-control" value="{{ $hashtags }}">
        </div>

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-primary">📤 Publier</button>
            <button type="button" id="regen-btn" class="btn btn-outline-secondary">🔁 Regénérer avec IA</button>
            <span id="regen-loader" class="text-muted d-none">Génération en cours...</span>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const regenBtn = document.getElementById('regen-btn');
    const loader = document.getElementById('regen-loader');
    const captionTextarea = document.querySelector('textarea[name="caption"]');
    const hashtagsInput = document.querySelector('input[name="hashtags"]');

    regenBtn.addEventListener('click', async function () {
        loader.classList.remove('d-none');
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
        loader.classList.add('d-none');
    });
</script>
@endpush
@endsection
