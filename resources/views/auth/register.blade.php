@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md bg-black text-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-center mb-6">{{ __('Register') }}</h2>
        
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-300">{{ __('Name') }}</label>
                <input type="text" id="name" name="name" required autofocus
                       class="w-full px-4 py-2 mt-2 bg-gray-800 text-white border border-gray-700 rounded focus:ring focus:ring-green-500 focus:outline-none">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-2 mt-2 bg-gray-800 text-white border border-gray-700 rounded focus:ring focus:ring-green-500 focus:outline-none">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-300">{{ __('Password') }}</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2 mt-2 bg-gray-800 text-white border border-gray-700 rounded focus:ring focus:ring-green-500 focus:outline-none">
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">{{ __('Confirm Password') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full px-4 py-2 mt-2 bg-gray-800 text-white border border-gray-700 rounded focus:ring focus:ring-green-500 focus:outline-none">
            </div>

            <!-- Submit -->
            <div class="mt-6">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded focus:outline-none focus:ring focus:ring-green-500">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
