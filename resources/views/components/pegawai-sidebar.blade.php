@php
$pegawai = match(true) {
    request()->is('pegawai/disperindag*') => 'disperindag',
    request()->is('pegawai/dkpp*') => 'dkpp',
    request()->is('pegawai/dtphp*') => 'dtphp',
    request()->is('pegawai/perikanan*') => 'perikanan',
    default => null,
};

$kelolaData = match(true) {
    request()->is('pegawai/disperindag*') => 'Kelola Disperindag',
    request()->is('pegawai/dkpp*') => 'Kelola Komoditas',
    request()->is('pegawai/dtphp*') => 'Kelola Tanaman',
    request()->is('pegawai/perikanan*') => 'Kelola Ikan',
};
$url = match(true) {
    request()->is('pegawai/disperindag*') => 'jenis_bahan_pokok',
    request()->is('pegawai/dkpp*') => 'jenis_komoditas',
    request()->is('pegawai/dtphp*') => 'jenis_tanaman',
    request()->is('pegawai/perikanan*') => 'jenis_ikan',
};
$namaRute = match(true) {
    request()->is('pegawai/disperindag*') => 'jenis-bahan-pokok.index',
    request()->is('pegawai/dkpp*') => 'jenis-komoditas.index',
    request()->is('pegawai/dtphp*') => 'jenis-tanaman.index',
    request()->is('pegawai/perikanan*') => 'jenis-ikan.index',
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
            <li class="hover:bg-pink-600 block py-2 px-4 rounded-lg text-sm max-md:bg-pink-650 {{ request()->is('pegawai/' . $pegawai . '/dashboard') ? 'bg-pink-450 text-yellow-300' : '' }}">
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
            <li class="hover:bg-pink-600 block py-2 px-4 rounded-lg text-sm max-md:bg-pink-650 {{ request()->is('pegawai/' . $pegawai . '/dashboard*') ? 'bg-pink-450 text-yellow-300' : '' }}">
              <a href="{{ route('pegawai.' . $pegawai . '.dashboard') }}" class="pl-4 gap-5 w-full flex items-center">
                  <i class="bi bi-house-door-fill"></i>
                  Dashboard
              </a>
            </li>

            <x-pegawai-sidebar-link 
              dataHref="{{ 'pegawai/' . $pegawai . '*' }}"
              dinas="{{ $pegawai }}"
              kelolaData="{{ $kelolaData }}"
              routeKelolaKomoditas="{{ $url }}"
              routeKelolaKomoditasView="{{ route($namaRute) }}"
              routeKelolaKomoditasCreate="{{ route($namaRute) }}"
            >
            <x-slot:name>PERIKANAN</x-slot:name>
            </x-pegawai-sidebar-link>  
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