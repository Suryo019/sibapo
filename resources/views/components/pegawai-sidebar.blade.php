@php
$routes = [
    'disperindag' => [
        'prefix' => 'pegawai/disperindag',
        'title' => 'Data Disperindag',
        'create' => 'pegawai.jenis-bahan-pokok.create',
        'index' => 'pegawai.jenis-bahan-pokok.index',
        'url' => 'pegawai/jenis_bahan_pokok',
    ],
    'dkpp' => [
        'prefix' => ['pegawai/dkpp', 'pegawai/jenis_komoditas'],
        'title' => 'Data Komoditas',
        'create' => 'pegawai.jenis-komoditas.create',
        'index' => 'pegawai.jenis-komoditas.index',
        'url' => 'pegawai/jenis_komoditas',
    ],
    'dtphp' => [
        'prefix' => ['pegawai/dtphp', 'pegawai/jenis_tanaman'],
        'title' => 'Data Tanaman',
        'create' => 'pegawai.jenis-tanaman.create',
        'index' => 'pegawai.jenis-tanaman.index',
        'url' => 'pegawai/jenis_tanaman',
    ],
    'perikanan' => [
        'prefix' => ['pegawai/perikanan', 'pegawai/jenis_ikan'],
        'title' => 'Data Ikan',
        'create' => 'pegawai.jenis-ikan.create',
        'index' => 'pegawai.jenis-ikan.index',
        'url' => 'pegawai/jenis_ikan',
    ],
];

$pegawai = null;

// dd($pegawai);
foreach ($routes as $key => $config) {
    $prefixes = (array) $config['prefix'];
    foreach ($prefixes as $prefix) {
        if (request()->is("$prefix*")) {
            $pegawai = $key;
            break 2;
        }
    }
}

$routeData = $pegawai ? $routes[$pegawai] : null;
@endphp


<!-- Sidebar -->
<aside {{ $attributes }}>
  <nav class="bg-pink-650 w-full h-full rounded-[30px] max-md:rounded-none flex flex-col place-content-between text-white font-medium shadow-pink-custom max-md:shadow-none overflow-hidden max-md:bg-transparent">
    <div class="bg-pink-650 max-md:bg-transparent rounded-xl relative z-10">
      <h2 class="md:hidden font-medium mb-3 text-black">Menu</h2>

      <div class="mb-5 justify-center mt-1 hidden md:flex">
        <img class="w-48 mt-4" src="{{ asset('/storage/img/logo-gabungan.png') }}" alt="logo">
      </div>
      

      <ul>
        {{-- Dashboard --}}
        <li class="max-md:mb-2 hover:bg-pink-600 block py-2 px-4 rounded-lg text-sm max-md:bg-pink-650 {{ request()->is('pegawai/' . $pegawai . '/dashboard*') ? 'text-yellow-300' : '' }}">
          <a href="{{ route('pegawai.' . $pegawai . '.dashboard') }}" class="pl-4 gap-5 w-full flex items-center">
            <i class="bi bi-house-door-fill"></i> Dashboard
          </a>
        </li>

        @if ($pegawai === 'disperindag')
          <x-pegawai-disperindag-sidebar-link />
        @elseif($routeData)
          <x-pegawai-sidebar-link
            :dinas="$pegawai"
            :kelolaData="$routeData['title']"
            :routeKelolaKomoditas="$routeData['url']"
            :routeKelolaKomoditasView="route($routeData['index'])"
            :routeKelolaKomoditasCreate="route($routeData['create'])"
          />
        @endif

        {{-- Beranda --}}
        <li class="mb-2 rounded-lg py-2 hover:bg-pink-600 md:bg-transparent max-md:bg-pink-650">
          <a href="{{ route('beranda') }}" class="flex items-center gap-5 text-sm pl-7 rounded-md {{ request()->is('logout') ? 'text-yellow-300' : '' }}">
            <iconify-icon icon="bi:box-arrow-left" class="text-xl"></iconify-icon>
            Beranda
          </a>
        </li>
      </ul>
    </div>

    {{-- Hiasan --}}
    <div class="w-[18rem] h-[15rem] p-2 fixed bottom-5 max-md:hidden">
      <img src="{{ asset('storage/img/kembang_sidebar.png') }}" class="h-full bg-contain" alt="Flower">
    </div>
  </nav>
</aside>
