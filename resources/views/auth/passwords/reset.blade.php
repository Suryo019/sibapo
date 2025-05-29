@extends('layouts.app')

@section('title', 'Reset Sandi | ' . config('app.name', 'Laravel'))

@section('content')
<div class="relative z-10 w-full lg:w-1/2 bg-white flex items-center justify-center py-10 lg:py-0">
    <div class="w-9/12">
        <h2 class="text-2xl lg:text-4xl font-semibold text-gray-800 mb-8 lg:mb-16 text-center">Reset Kata Sandi</h2>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus
                    placeholder="Masukkan Email"
                    class="w-full border-b border-pink-400 outline-none py-2 text-sm text-gray-700 placeholder-gray-400 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 mb-2">Kata Sandi Baru</label>
                <input id="password" type="password" name="password" required
                    placeholder="Masukkan Kata Sandi Baru"
                    class="w-full border-b border-pink-400 outline-none py-2 text-sm text-gray-700 placeholder-gray-400 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password-confirm" class="block text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                <input id="password-confirm" type="password" name="password_confirmation" required
                    placeholder="Ulangi Kata Sandi"
                    class="w-full border-b border-pink-400 outline-none py-2 text-sm text-gray-700 placeholder-gray-400">
            </div>

            <!-- Submit -->
            <div class="flex justify-center">
                <button type="submit"
                    class="w-32 bg-pink-500 text-white py-2 rounded-full font-semibold hover:bg-pink-600">
                    Reset Sandi
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
