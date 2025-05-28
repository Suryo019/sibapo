@extends('layouts.app')

@section('content')
<div class="relative z-10 w-full lg:w-1/2 bg-white flex items-center justify-center py-10 lg:py-0">
  <div class="w-9/12">
      <h2 class="text-2xl lg:text-4xl font-semibold text-gray-800 mb-8 lg:mb-16 text-center">Reset Kata Sandi Anda</h2>
      
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

      <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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

          <!-- Submit -->
          <div class="flex justify-center">
              <button type="submit" class="px-8 bg-pink-500 text-white py-2 rounded-full font-semibold hover:bg-pink-600">
                  {{ __('Kirim Link Reset Sandi') }}
              </button>
          </div>
      </form>
  </div>
</div>
@endsection
