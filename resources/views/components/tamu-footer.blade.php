<footer class="text-white">
  <!-- Bagian Atas Pink -->
  <div class="bg-pink-650 relative overflow-hidden py-14 px-6 md:px-20">
    <!-- Konten teks -->
    <div class="max-w-8xl mx-auto flex flex-col gap-3 items-start text-left relative z-10 md:pr-40">
      <h2 class="text-2xl md:text-5xl font-semibold">Butuh Bantuan?</h2>
      <p class="text-sm md:text-md mt-1 mb-6">Tanyakan apapun dan kami siap membantu Anda!</p>
      <a href="https://s.id/Wadul-Guse" target="_blank" class="bg-pink-650 text-white font-medium px-6 md:px-10 mb-6 py-2 rounded-full border border-white">
        Hubungi Kami Sekarang
      </a>
    </div>

    <!-- Gambar bunga (background) -->
    <img
      src="{{ asset('storage/img/kembang-4.png') }}"
      alt=""
      class="absolute right-0 top-0 md:top-10 md:-right-16 md:w-auto h-auto md:h-full object-contain z-0 md:opacity-100 pointer-events-none hidden md:block"/>
  </div>

  <!-- Bagian Bawah Abu-Abu -->
  <div class="bg-gray-900 py-12 px-6 md:px-20">
    <div class="max-w-8xl mx-auto grid grid-cols-1 justify-items-start md:justify-items-center sm:grid-cols-2 md:grid-cols-3 gap-10 md:gap-40 text-center md:text-left ">
      
      <!-- Logo & deskripsi -->
      <div class="flex flex-col md:items-start ">
        <img src="{{ asset('storage/img/logo-cintako.png') }}" alt="Logo SIBAPO" class="w-[65%]  mb-6 mx-auto md:mx-0">
        <p class="text-sm text-justify">
         Cinta Ekonomi (CintaKo) adalah pusat data harga bahan pangan di seluruh wilayah Kabupaten Jember yang diperbarui setiap hari.
        </p>
        <p class="text-xs mt-4 text-start">
          Copyright © 2025 Cinta Ekonomi
        </p>
      </div>

      <!-- Link Situs -->
      <div>
        <h3 class="text-lg font-semibold mb-4 text-start">SITUS</h3>
        <ul class="space-y-2 text-sm text-start">
          <li><a href="{{ route('tamu.komoditas') }}" class="text-white hover:underline">Komoditas</a></li>
          <li><a href="{{ route('tamu.pasar.search') }}" class="text-white hover:underline">Pasar</a></li>
          <li><a href="{{ route('tamu.statistik') }}" class="text-white hover:underline">Statistik</a></li>
          <li><a href="{{ route('tamu.metadata') }}" class="text-white hover:underline">Metadata</a></li>
          <li><a href="{{ route('tamu.tentang-kami') }}" class="text-white hover:underline">Tentang Kami</a></li>
        </ul>
      </div>

      <!-- Alamat -->
      <div>
        <h3 class="text-lg font-semibold mb-4 text-start">ALAMAT</h3>
        <p class="text-sm leading-relaxed text-start">
          Jl. Sudarman No.1, Kp. Using,<br>
          Jemberlor, Kec. Patrang,<br>
          Kabupaten Jember, Jawa Timur<br>
          68118
        </p>
      </div>

    </div>
  </div>
</footer>