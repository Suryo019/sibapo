<header class="relative flex items-center py-12 px-4 sm:px-6 -mt-20 w-full h-auto md:h-[90vh] bg-white text-gray-800 shadow-lg overflow-hidden">

  <!-- Background Image -->
  <img src="{{ asset('storage/img/header-bg-4.png') }}"
       alt="bg-header"
       class="absolute inset-0 w-full h-full object-cover z-0">

  <!-- Konten Utama -->
  <div class="relative z-10 max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-10 items-center">

    <!-- Kolom Kiri: Teks -->
    <div class="text-center md:text-left space-y-4 px-2 sm:px-4">
      <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-bold text-pink-600"
          style="text-shadow: 3px 3px 6px rgba(0,0,0,0.3);">
        JEMBER
      </h1>
      <p class="text-sm sm:text-base md:text-lg leading-relaxed text-white"
         style="text-shadow: 3px 3px 6px rgba(0,0,0,0.3);">
        Cinta Ekonomi menyajikan data harga bahan pangan di seluruh Kabupaten Jember,
        dengan pembaruan yang dilakukan setiap hari.
        <a href="{{ route('tamu.tentang-kami') }}">
          <b class="text-white">Selengkapnya...</b>
        </a>
      </p>
      <a href="https://s.id/Wadul-Guse" target="_blank"
         class="inline-block bg-pink-600 text-white text-sm font-semibold px-6 py-2 rounded-full hover:bg-pink-700 transition">
        Hubungi Kami
      </a>
    </div>

    <!-- Kolom Kanan: Gambar -->
    <div class="flex justify-center md:justify-end">
      <img src="{{ asset('storage/img/dashboard-vector.png') }}"
           alt="Bupati Jember"
           class="w-40 sm:w-56 md:w-64 lg:w-80 xl:w-96 max-h-[32rem] object-contain">
    </div>

  </div>
</header>
<br><br>