@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Mon Profil</h2>

    {{-- ✅ Message succès --}}
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">✅ Profil mis à jour.</div>
    @elseif (session('status') === 'password-updated')
        <div class="alert alert-success">🔐 Mot de passe mis à jour.</div>
    @endif

    {{-- ✅ Formulaire mise à jour du profil --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mb-5">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="avatar" class="form-label">Avatar</label><br>
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle mb-2" width="80" height="80">
            @endif
            <input type="file" name="avatar" class="form-control">
        </div>

        <div class="mb-3">
            <label for="name">Nom</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="bio">Bio</label>
            <textarea name="bio" rows="3" class="form-control">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="sport">Sport</label>
                <input type="text" name="sport" value="{{ old('sport', $user->sport) }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label for="localisation">Localisation</label>
                <input type="text" name="localisation" value="{{ old('localisation', $user->localisation) }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label for="level">Niveau</label>
                <input type="text" name="level" value="{{ old('level', $user->level) }}" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">💾 Sauvegarder</button>
    </form>

    {{-- ✅ Formulaire changement de mot de passe --}}
    <h4 class="mb-3">Changer le mot de passe</h4>
    <form method="POST" action="{{ route('password.update') }}" class="mb-5">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="current_password">Mot de passe actuel</label>
            <input type="password" name="current_password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-warning">🔐 Mettre à jour</button>
    </form>

    {{-- ✅ Suppression du compte --}}
    <h4 class="text-danger">Supprimer le compte</h4>
    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label for="password">Confirmez votre mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')">
            🗑️ Supprimer définitivement
        </button>
    </form>
</div>
@endsection
