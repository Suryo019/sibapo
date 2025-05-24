@php
$pegawai = match(true) {
    request()->is('pegawai/disperindag*') => 'disperindag',
    request()->is('pegawai/dkpp*') => 'dkpp',
    request()->is('pegawai/dtphp*') => 'dtphp',
    request()->is('pegawai/perikanan*') => 'perikanan',

    request()->is('pegawai/jenis_komoditas*') => 'dkpp',
    request()->is('pegawai/jenis_tanaman*') => 'dtphp',
    request()->is('pegawai/jenis_ikan*') => 'perikanan',
    default => null,
};

$kelolaData = match(true) {
    request()->is('pegawai/disperindag*') => 'Data Disperindag',
    request()->is('pegawai/dkpp*') => 'Data Komoditas',
    request()->is('pegawai/dtphp*') => 'Data Tanaman',
    request()->is('pegawai/perikanan*') => 'Data Ikan',

    request()->is('pegawai/jenis_komoditas*') => 'Data komoditas',
    request()->is('pegawai/jenis_tanaman*') => 'Data Tanaman',
    request()->is('pegawai/jenis_ikan*') => 'Data Ikan',
};

$url = match(true) {
    request()->is('pegawai/disperindag*') => 'pegawai/jenis_bahan_pokok',
    request()->is('pegawai/dkpp*') => 'pegawai/jenis_komoditas',
    request()->is('pegawai/dtphp*') => 'pegawai/jenis_tanaman',
    request()->is('pegawai/perikanan*') => 'pegawai/jenis_ikan',

    request()->is('pegawai/jenis_komoditas*') => 'pegawai/jenis_komoditas',
    request()->is('pegawai/jenis_tanaman*') => 'pegawai/jenis_tanaman',
    request()->is('pegawai/jenis_ikan*') => 'pegawai/jenis_ikan',
};
$ruteName = match(true) {
    request()->is('pegawai/dkpp*') => 'jenis-komoditas',
    request()->is('pegawai/dtphp*') => 'jenis-tanaman',
    request()->is('pegawai/perikanan*') => 'jenis-ikan',

    request()->is('pegawai/jenis_komoditas*') => 'jenis-komoditas',
    request()->is('pegawai/jenis_tanaman*') => 'jenis-tanaman',
    request()->is('pegawai/jenis_ikan*') => 'jenis-ikan',
};

$namaRuteView = match(true) {
    request()->is('pegawai/disperindag*') => 'pegawai.jenis-bahan-pokok.index',
    request()->is('pegawai/dkpp*') => 'pegawai.jenis-komoditas.index',
    request()->is('pegawai/dtphp*') => 'pegawai.jenis-tanaman.index',
    request()->is('pegawai/perikanan*') => 'pegawai.jenis-tanaman.index',

    request()->is('pegawai/jenis_komoditas*') => 'pegawai.jenis-komoditas.index',
    request()->is('pegawai/jenis_tanaman*') => 'pegawai.jenis-tanaman.index',
    request()->is('pegawai/jenis_ikan*') => 'pegawai.jenis-tanaman.index',
};
@endphp

<!-- Sidebar -->
<aside {{ $attributes }}>
  <nav class="bg-pink-650 w-full h-full rounded-[30px] max-md:rounded-none flex flex-col place-content-between text-white font-medium shadow-pink-custom max-md:shadow-none overflow-hidden max-md:bg-transparent">
    <div class="bg-pink-650 max-md:bg-transparent rounded-xl relative z-10">
      {{-- Header --}}
      <h2 class="md:hidden font-medium mb-3 text-black">Menu</h2>
      <div class="mb-5 justify-center mt-1 hidden md:flex">
        <img class="scale-50 ml-4" src="{{ asset('storage/img/logo.png') }}" alt="logo">
      </div>
  
        {{-- Link --}}
        @if ($pegawai == 'disperindag')
          <ul>
            {{-- Dashboard --}}
            <li class="hover:bg-pink-600 block py-2 px-4 rounded-lg text-sm max-md:bg-pink-650 {{ request()->is('pegawai/' . $pegawai . '/dashboard') ? 'text-yellow-300' : '' }}">
              <a href="{{ route('pegawai.' . $pegawai . '.dashboard') }}" class="pl-4 gap-5 w-full flex items-center">
                  <i class="bi bi-house-door-fill"></i>
                  Dashboard
              </a>
            </li>

            <x-pegawai-disperindag-sidebar-link> </x-pegawai-disperindag-sidebar-link>

            <li class="mb-2 rounded-lg py-2 hover:bg-pink-600 md:bg-transparent max-md:bg-pink-650">
              <a href="{{ route('beranda') }}" class="flex items-center gap-5 text-sm pl-7 rounded-md {{ request()->is('logout') ? 'text-yellow-300' : '' }}">
                <iconify-icon icon="bi:box-arrow-left" class="text-xl"></iconify-icon>
                Logout
              </a>
            </li>
          </ul>
        @else  
          <ul>
            <li class="hover:bg-pink-600 block py-2 px-4 rounded-lg text-sm max-md:bg-pink-650 {{ request()->is('pegawai/' . $pegawai . '/dashboard*') ? 'text-yellow-300' : '' }}">
              <a href="{{ route('pegawai.' . $pegawai . '.dashboard') }}" class="pl-4 gap-5 w-full flex items-center">
                  <i class="bi bi-house-door-fill"></i>
                  Dashboard
              </a>
            </li>

            <x-pegawai-sidebar-link
              dinas="{{ $pegawai }}"
              kelolaData="{{ $kelolaData }}"
              routeKelolaKomoditas="{{ $url }}"
              routeKelolaKomoditasView="{{ route($namaRuteView) }}"
              routeKelolaKomoditasCreate="{{ route('pegawai.' . $ruteName . '.create') }}"
            >
            </x-pegawai-sidebar-link>  

            {{-- logout --}}
            <li class="mb-2 rounded-lg py-2 hover:bg-pink-600 md:bg-transparent max-md:bg-pink-650">
              <a href="{{ route('beranda') }}" class="flex items-center gap-5 text-sm pl-7 rounded-md {{ request()->is('logout') ? 'text-yellow-300' : '' }}">
                <iconify-icon icon="bi:box-arrow-left" class="text-xl"></iconify-icon>
                Logout
              </a>
            </li>
          </ul>
        @endif
    </div>
    
      {{-- Decoration --}}
      <div class="w-[18rem] h-[15rem] p-2 fixed bottom-5 max-md:hidden">
        <img src="{{ asset('storage/img/kembang_sidebar.png') }}" class="h-full bg-contain" alt="Flower">
      </div>
    </nav>
</aside>