@extends('layouts.app')

@section('content')
<div class="container py-5 max-w-3xl mx-auto">
    <h2 class="mb-4">📝 Nouvelle Publication</h2>

    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Légende</label>
            <textarea name="caption" class="form-control" rows="3">{{ old('caption') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Hashtags</label>
            <input type="text" name="hashtags" class="form-control" value="{{ old('hashtags') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Sport</label>
            <input type="text" name="sport" class="form-control" value="{{ old('sport') }}">
        </div>

        <button type="submit" class="btn btn-primary">🤖 Prévisualiser avec IA</button>
    </form>
</div>
@endsection
