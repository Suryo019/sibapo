<footer class="text-white">
  
  <!-- Bagian Atas pink -->
  <div class="bg-pink-600 py-14 h-80 px-6 relative overflow-hidden">
    <div class="max-w-6xl mx-auto flex flex-col gap-4 items-start text-left relative z-10">
      <h2 class="text-2xl md:text-5xl font-semibold">Butuh Bantuan?</h2>
      <p class="text-sm mt-1 mb-4">Tanyakan apapun dan kami siap membantu Anda!</p>
      <a href="#" class="bg-pink-600 text-white font-medium px-10 py-2 rounded-full border border-white ">
        Hubungi Kami Sekarang
      </a>
    </div>
    <img src="{{ asset('storage/img/kembang-sidebar-2.png') }}" 
         alt=""
         class="absolute -bottom-16 -right-20 scale-75 md:scale-90 lg:scale-100 w-80 h-60 max-w-sm pointer-events-none select-none opacity-70 z-0" />
  </div>

  <!-- Bagian Bawah abu" -->
  <div class="bg-gray-900 py-14 px-6 h-90">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-40">
      <div>
        <div class="flex items-center gap-2 mb-3">
          <img src="{{ asset('storage/img/logo.png') }}" alt="Logo SIBAPO" class="h-30">
        </div>
        <p class="text-sm text-white">
          Sistem Informasi Bahan Pokok (SIBAPO) adalah pusat data harga bahan pangan di seluruh wilayah Kabupaten Jember yang diperbarui setiap hari.
        </p>
        <p class="text-xs text-white mt-4">
          Copyright © 2025 Sistem Informasi Bahan Pokok
        </p>
      </div>

      <!-- Link Situs -->
      <div>
        <h3 class="text-lg font-semibold mb-4">SITUS</h3>
        <ul class="space-y-2 text-sm ">
          <li><a href="#" class="text-white">Komoditas</a></li>
          <li><a href="#" class="text-white">Pasar</a></li>
          <li><a href="#" class="text-white">Statistik</a></li>
          <li><a href="#" class="text-white">Metadata</a></li>
          <li><a href="#" class="text-white">Tentang Kami</a></li>
        </ul>
      </div>

      <!-- Alamat -->
      <div>
        <h3 class="text-lg font-semibold mb-4">ALAMAT</h3>
        <p class="text-sm white leading-relaxed">
          Jl. Sudarman No.1, Kp. Using,<br>
          Jemberlor, Kec. Patrang,<br>
          Kabupaten Jember, Jawa Timur<br>
          68118
        </p>
      </div>

    </div>
  </div>

</footer>
