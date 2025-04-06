<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Profil de {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        @if ($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" class="h-24 w-24 rounded-full object-cover mb-4">
        @endif

        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Bio :</strong> {{ $user->bio }}</p>
        <p><strong>Sport :</strong> {{ $user->sport }}</p>
        <p><strong>Localisation :</strong> {{ $user->localisation }}</p>
        <p><strong>Niveau :</strong> {{ $user->level }}</p>
    </div>
</x-app-layout>
