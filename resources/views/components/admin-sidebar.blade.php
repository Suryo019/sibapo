{{-- @dd(request()->is('dashboard')) --}}

<aside {{ $attributes }}>
  <nav class="bg-pink-650 w-full h-full rounded-[30px] max-md:rounded-none flex flex-col place-content-between text-white font-medium shadow-pink-custom max-md:shadow-none overflow-hidden max-md:bg-transparent">
    <div class="bg-pink-650 max-md:bg-transparent rounded-xl">
      {{-- Header --}}
      <h2 class="md:hidden font-medium mb-3 text-black">Menu</h2>
      <div class="mb-5 justify-center mt-1 hidden md:flex">
        <img class="scale-50 ml-4" src="{{ asset('img/logo.png') }}" alt="logo">
      </div>

      {{-- Link --}}
      <ul class="">
        <!-- Dashboard -->
        <li class="mb-2 rounded-lg py-2 hover:bg-pink-600 md:bg-transparent max-md:bg-pink-650">
          <a href="{{ route('dashboard') }}" class="flex items-center gap-5 text-sm pl-7 rounded-md {{ request()->is('dashboard') ? 'text-yellow-300' : '' }}">
            <iconify-icon icon="bi:house-door-fill" class="text-xl"></iconify-icon>
            Dashboard
          </a>
        </li>
  
        <!-- DISPERINDAG -->
        <x-admin-sidebar-link 
            dataHref="disperindag*"
            dinas="disperindag"
            viewHref="{{ route('disperindag.index') }}"
            viewDetailHref="{{ route('disperindag.detail') }}"
            createHref="{{ route('disperindag.create') }}"
            viewData="Lihat Data"
            createData="Tambah Data"
            updateData="Ubah Data"
            icon="mage:basket-fill"
            >
            <x-slot:name>DISPERINDAG</x-slot:name>
        </x-admin-sidebar-link>


        <!-- DKPP -->
        <x-admin-sidebar-link 
        dataHref="dkpp*"
        dinas="dkpp"
        viewHref="{{ route('dkpp.index') }}"
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
        viewHref="{{ route('dtphp.produksi') }}"
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
        viewHref="{{ route('perikanan.index') }}"
        createHref="{{ route('perikanan.create') }}"
        :viewData="'Lihat Data'"
        :createData="'Tambah Data'"
        updateData="Ubah Data"
        icon="majesticons:fish"
        >
        <x-slot:name>PERIKANAN</x-slot:name>
        </x-admin-sidebar-link>
      </ul>
    </div>
  
    {{-- Decoration --}}
    <div class="w-[18rem] h-[15rem] p-2 fixed bottom-5 max-md:hidden">
      <img src="{{ asset('img/kembang_sidebar.png') }}" class="h-full bg-contain" alt="Flower">
    </div>
  </nav>
    
</aside>