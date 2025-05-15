<header class="bg-gradient-to-r from-pink-100 via-white to-pink-100 py-16 px-6 -mt-20">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

    <!-- Teks Kiri -->
    <div class="text-center md:text-left">
      <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-bold text-pink-600 mb-4"
          style="text-shadow: 3px 3px 6px rgba(0,0,0,0.3);">
        JEMBER
      </h1>
      <p class="text-base sm:text-lg text-pink-600 mb-2"
         style="text-shadow: 3px 3px 6px rgba(0,0,0,0.3);">
        Semua Dicintai Fawait.
      </p>
      <p class="text-sm sm:text-base md:text-lg leading-relaxed text-pink-600 mb-4"
         style="text-shadow: 3px 3px 6px rgba(0,0,0,0.3);">
        Sistem Informasi Bahan Pokok menyajikan data harga bahan pangan di seluruh Kabupaten Jember, 
        dengan pembaruan yang dilakukan setiap hari.
      </p>
      <a href="{{ route('tamu.hubungi-kami') }}"
         class="mt-4 inline-block bg-pink-600 text-white text-sm font-semibold px-6 py-2 rounded-full hover:bg-pink-700 transition">
        Hubungi Kami
      </a>
    </div>

    <!-- Gambar Bupati -->
    <div class="flex justify-center md:justify-end">
      <img src="{{ asset('storage/img/s2.png') }}" alt="Bupati Jember"
           class="w-40 sm:w-56 md:w-64 lg:w-80 xl:w-96 max-h-[32rem] object-contain">
    </div>

  </div>
</header>

  