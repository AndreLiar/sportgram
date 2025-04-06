<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
            
            <!-- Custom Profile Form -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-3xl">
                    @if (session('status') === 'profile-updated')
                        <div class="mb-4 text-sm text-green-600">
                            {{ __('Profil mis à jour.') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Avatar -->
                        <div>
                            <x-input-label for="avatar" :value="__('Avatar')" />
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar actuel" class="mt-2 h-20 w-20 rounded-full object-cover">
                            @endif
                            <x-text-input id="avatar" name="avatar" type="file" class="mt-2 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                        </div>

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nom')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Bio -->
                        <div>
                            <x-input-label for="bio" :value="__('Bio')" />
                            <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('bio', $user->bio) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                        </div>

                        <!-- Sport -->
                        <div>
                            <x-input-label for="sport" :value="__('Sport')" />
                            <x-text-input id="sport" name="sport" type="text" class="mt-1 block w-full" :value="old('sport', $user->sport)" />
                            <x-input-error class="mt-2" :messages="$errors->get('sport')" />
                        </div>

                        <!-- Localisation -->
                        <div>
                            <x-input-label for="localisation" :value="__('Localisation')" />
                            <x-text-input id="localisation" name="localisation" type="text" class="mt-1 block w-full" :value="old('localisation', $user->localisation)" />
                            <x-input-error class="mt-2" :messages="$errors->get('localisation')" />
                        </div>

                        <!-- Niveau -->
                        <div>
                            <x-input-label for="level" :value="__('Niveau')" />
                            <x-text-input id="level" name="level" type="text" class="mt-1 block w-full" :value="old('level', $user->level)" />
                            <x-input-error class="mt-2" :messages="$errors->get('level')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Sauvegarder') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Update Form -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Form -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
