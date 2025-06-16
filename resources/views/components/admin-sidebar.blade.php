{{-- @dd(request()->is('dashboard')) --}}

<aside {{ $attributes }}>
  <nav class="bg-pink-650 w-full h-full rounded-[30px] overflow-hidden max-md:rounded-none flex flex-col text-white font-medium shadow-pink-custom max-md:shadow-none max-md:bg-transparent">

    {{-- Header --}}
    <div class="bg-pink-650 max-md:bg-transparent rounded-xl relative z-10 shrink-0">
      <h2 class="md:hidden font-medium mb-3 text-black">Menu</h2>
      <div class="mb-5 justify-center mt-1 hidden md:flex">
        <img class="w-48 mt-4" src="{{ asset('storage/img/logo-gabungan.png') }}" alt="logo">
      </div>
    </div>

    {{-- Scrollable Menu Content --}}
    <div class="overflow-y-auto scrollbar-thin flex-1">
      <ul class="">
        <!-- Dashboard -->
        <li class="mb-2 rounded-lg py-2 hover:bg-pink-600 md:bg-transparent max-md:bg-pink-650">
          <a href="{{ route('dashboard') }}" class="flex items-center gap-5 text-sm pl-7 rounded-md {{ request()->is('dashboard') ? 'text-yellow-300' : '' }}">
            <iconify-icon icon="bi:house-door-fill" class="text-xl"></iconify-icon>
            Dashboard
          </a>
        </li>

        {{-- Kelola dinas --}}
        <span class="block opacity-75 text-sm pl-7 my-4 max-xl:hidden"> KELOLA DATA DINAS </span>

        <!-- DISPERINDAG -->
        <x-disperindag-sidebar-link></x-disperindag-sidebar-link>

        <!-- DKPP -->
        <x-admin-sidebar-link 
        dataHref="dkpp*"
        dinas="dkpp"
        kelolaData="Data Komoditas"
        routeKelolaKomoditas="jenis_komoditas"
        routeKelolaKomoditasView="{{ route('jenis-komoditas.index') }}"
        routeKelolaKomoditasCreate="{{ route('jenis-komoditas.create') }}"
        viewHref="{{ route('dkpp.index') }}"
        viewDetailHref="{{ route('dkpp.detail') }}"
        createHref="{{ route('dkpp.create') }}"
        :viewData="'Lihat Data'"
        :createData="'Tambah Data'"
        updateData="Ubah Data"
        icon="healthicons:plantation-worker-alt"
        >
        <x-slot:name>DKPP</x-slot:name>
        </x-admin-sidebar-link>

        <!-- DTPHP -->
        <x-admin-sidebar-link 
        dataHref="dtphp*"
        dinas="dtphp"
        kelolaData="Data Tanaman"
        routeKelolaKomoditas="jenis_tanaman"
        routeKelolaKomoditasView="{{ route('jenis-tanaman.index') }}"
        routeKelolaKomoditasCreate="{{ route('jenis-tanaman.create') }}"
        viewHref="{{ route('dtphp.produksi') }}"
        viewHrefPanen="{{ route('dtphp.panen') }}"
        viewDetailHref="{{ route('dtphp.detail.produksi') }}"
        viewDetailHrefPanen="{{ route('dtphp.detail.panen') }}"
        createHref="{{ route('dtphp.create') }}"
        :viewData="'Lihat Data'"
        :createData="'Tambah Data'"
        updateData="Ubah Data"
        icon="carbon:agriculture-analytics"
        >
        <x-slot:name>DTPHP</x-slot:name>
        </x-admin-sidebar-link>

        <!-- PERIKANAN -->
        <x-admin-sidebar-link 
        dataHref="perikanan*"
        dinas="perikanan"
        kelolaData="Data Ikan"
        routeKelolaKomoditas="jenis_ikan"
        routeKelolaKomoditasView="{{ route('jenis-ikan.index') }}"
        routeKelolaKomoditasCreate="{{ route('jenis-ikan.create') }}"
        viewHref="{{ route('perikanan.index') }}"
        viewDetailHref="{{ route('perikanan.detail') }}"
        createHref="{{ route('perikanan.create') }}"
        :viewData="'Lihat Data'"
        :createData="'Tambah Data'"
        updateData="Ubah Data"
        icon="majesticons:fish"
        >
        <x-slot:name>PERIKANAN</x-slot:name>
        </x-admin-sidebar-link>

        <!--kelola akun-->
        <span class="block opacity-75 text-sm pl-7 my-4 max-xl:hidden"> KELOLA DATA AKUN </span>

        <x-admin-makundinas-sidebar-link 
        dataHref="makundinas*"
        dinas="makundinas"
        viewHref="{{ route('makundinas.index') }}"
        createHref="{{ route('makundinas.create') }}"
        :viewData="'Lihat Data'"
        :createData="'Tambah Data'"
        updateData="Ubah Data"
        icon="material-symbols:group"
        >
        <x-slot:name>Kelola data akun</x-slot:name>
        </x-admin-makundinas-sidebar-link>

        <li class="mb-2 rounded-lg py-2 hover:bg-pink-600 md:bg-transparent max-md:bg-pink-650">
          <a href="{{ route('beranda') }}" class="flex items-center gap-5 text-sm pl-7 rounded-md {{ request()->is('logout') ? 'text-yellow-300' : '' }}">
            <iconify-icon icon="bi:box-arrow-left" class="text-xl"></iconify-icon>
            Beranda
          </a>
        </li>
      </ul>
    </div>

    {{-- Decoration --}}
    {{-- <div class="w-[18rem] h-[15rem] p-2 shrink-0 hidden max-md:hidden">
      <img src="{{ asset('storage/img/kembang_sidebar.png') }}" class="h-full bg-contain" alt="Flower">
    </div> --}}
  </nav>
</aside>