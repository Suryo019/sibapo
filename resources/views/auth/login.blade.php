@extends('layouts.app')

@section('title', 'Login | ' . config('app.name', 'Laravel'))

@section('content')
<div class="relative z-10 w-full lg:w-1/2 bg-white flex items-center justify-center py-10 lg:py-0">
  <div class="w-9/12">
      <h2 class="text-2xl lg:text-4xl font-semibold text-gray-800 mb-8 lg:mb-16 text-center">Masuk ke akun Anda</h2>
      @if (session('status'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('status') }}',
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Tutup'
                    });
                });
            </script>
        @endif
      <form method="POST" action="{{ route('login') }}" class="space-y-6">
          @csrf

          <!-- Email -->
          <div>
              <label for="email" class="block text-gray-700 mb-2">Email</label>
              <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                  placeholder="Masukkan Email"
                  class="w-full border-b border-pink-400 outline-none py-2 text-sm text-gray-700 placeholder-gray-400 @error('email') border-red-500 @enderror">
              @error('email')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
              @enderror
          </div>

          <!-- Password -->
          <div>
              <label for="password" class="block text-gray-700 mb-2">Kata Sandi</label>
              <input id="password" type="password" name="password" required
                  placeholder="Masukkan Kata Sandi"
                  class="w-full border-b border-pink-400 outline-none py-2 text-sm text-gray-700 placeholder-gray-400 @error('password') border-red-500 @enderror">
              @error('password')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
              @enderror

              <div class="flex w-full justify-between mt-4">
                  <!-- Remember Me -->
                  <div class="flex items-center">
                      <input class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      <label for="remember" class="ml-2 block text-sm text-gray-900">Ingat Saya</label>
                  </div>
    
                  {{-- Lupa password --}}
                  <div class="text-right text-xs">
                      @if (Route::has('password.request'))
                          <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline">Lupa Kata Sandi?</a>
                      @endif
                  </div>
              </div>
          </div>

          

          <!-- Submit -->
          <div class="flex justify-center">
              <button type="submit" class="w-32 bg-pink-500 text-white py-2 rounded-full font-semibold hover:bg-pink-600">
                  Login
              </button>
          </div>
      </form>
  </div>
</div>
@endsection