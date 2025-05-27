<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login SIBAPO</title>
</head>
<body class="min-h-screen flex flex-col lg:flex-row font-sans">

  <div class="w-full lg:w-1/2 h-[250px] lg:h-screen relative overflow-hidden">
    <!-- Background-->
    <img src="{{ asset('storage/img/bg-login.jpg') }}" alt="Background Pink" class="w-full h-full object-cover absolute inset-0 z-0" />

    <div class="relative z-10 flex flex-col justify-between items-center h-full px-8 py-10 text-white text-center">

      <div class="space-y-10 mt-4 lg:space-y-20">
        <!-- Logo Pemerintah -->
        <img src="{{ asset('storage/img/LogoPemda.png') }}" class="w-20 lg:w-24 mx-auto hidden lg:block" />

        <!-- Selamat Datang -->
        <h2 class="text-xl lg:text-2xl font-semibold hidden lg:block">Selamat Datang</h2>

        <!-- Logo SIBAPO -->
        <img src="{{ asset('storage/img/logo.png') }}" class="w-40 lg:w-80 mx-auto" />

        <!-- Deskripsi -->
        <p class="text-sm lg:text-base leading-relaxed max-w-sm mx-auto mt-4 lg:mt-6 hidden lg:block">
          Semua dicintai fawait.<br />
          Sistem Informasi Bahan Pokok Penyusunan data kerja bahan peran di seluruh Kabupaten Jember, dengan pembaruan yang dilakukan setiap hari.
        </p>
      </div>

      <!-- Footer -->
      <div class="text-xs lg:text-lg hidden lg:block">
        Bagian Tata Pemerintahan Setda<br />
        Kabupaten Jember
      </div>
    </div>
  </div>


  <div class="w-full lg:w-1/2 bg-white flex items-center justify-center px-6 lg:px-12 py-10 lg:py-0">
    <div class="w-full max-w-md">
      <h2 class="text-2xl lg:text-4xl font-semibold text-gray-800 mb-8 lg:mb-16 text-center">Masuk ke akun Anda</h2>
      <form class="space-y-6">
        <!-- Username -->
        <div>
          <label class="block text-gray-700 mb-2">Username/Email</label>
          <input type="text" placeholder="Masukkan Username/Email"
            class="w-full border-b border-pink-400 outline-none py-2 text-sm text-gray-700 placeholder-gray-400" />
        </div>
        <!-- Password -->
        <div>
          <label class="block text-gray-700 mb-2">Kata Sandi</label>
          <input type="password" placeholder="Masukkan Kata Sandi"
            class="w-full border-b border-pink-400 outline-none py-2 text-sm text-gray-700 placeholder-gray-400" />
          <div class="text-right text-xs mt-2">
            <a href="#" class="text-blue-500 hover:underline">Lupa Kata Sandi?</a>
          </div>
        </div>

        <!-- Button -->
        <div class="flex justify-center">
          <button type="submit" class="w-32 bg-pink-500 text-white py-2 rounded-full font-semibold hover:bg-pink-600">
            Login
          </button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
