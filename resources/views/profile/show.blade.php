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

        <div class="flex items-center gap-4 mb-4">
            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
            
            @auth
                @if (auth()->id() !== $user->id)
                    <form method="POST" action="{{ route('users.follow', $user) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ auth()->user()->isFollowing($user) ? 'Ne plus suivre' : 'Suivre' }}
                        </button>
                    </form>
                    <div class="flex items-center gap-4 text-sm text-gray-700">
    <span><strong>{{ $user->followers()->count() }}</strong> abonné{{ $user->followers()->count() > 1 ? 's' : '' }}</span>
    <span><strong>{{ $user->following()->count() }}</strong> suivis</span>
</div>

                @endif
            @endauth
        </div>

        <div class="space-y-2">
            <p><strong>Email :</strong> {{ $user->email }}</p>
            <p><strong>Bio :</strong> {{ $user->bio }}</p>
            <p><strong>Sport :</strong> {{ $user->sport }}</p>
            <p><strong>Localisation :</strong> {{ $user->localisation }}</p>
            <p><strong>Niveau :</strong> {{ $user->level }}</p>
        </div>
    </div>
</x-app-layout>