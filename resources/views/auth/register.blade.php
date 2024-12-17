<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="bg-gray-800 text-white p-8 rounded-lg shadow-lg">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Name')" class="text-lg font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full bg-gray-700 text-white border border-green-600" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" class="text-lg font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-700 text-white border border-green-600" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" class="text-lg font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-700 text-white border border-green-600" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-lg font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-700 text-white border border-green-600" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <x-primary-button class="ml-3 bg-green-600 hover:bg-green-700 text-white">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
