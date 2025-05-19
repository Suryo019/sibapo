@php
$pegawai = match(true) {
    request()->is('pegawai/disperindag*') => 'disperindag',
    request()->is('pegawai/dkpp*') => 'dkpp',
    request()->is('pegawai/dtphp*') => 'dtphp',
    request()->is('pegawai/perikanan*') => 'perikanan',
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
            <x-pegawai-sidebar-link 
                  href="{{ route('pegawai.' . $pegawai . '.dashboard') }}" 
                  icon="bi-house-door-fill"
                  class="hover:bg-pink-600 block py-2 px-4 rounded-lg text-sm max-md:bg-pink-650 {{ request()->is('pegawai/' . $pegawai . '/dashboard') ? 'bg-pink-450 text-yellow-300' : '' }}">
                  Dashboard
            </x-pegawai-sidebar-link>

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
              <x-pegawai-sidebar-link 
                  href="{{ route('pegawai.' . $pegawai . '.dashboard') }}" 
                  icon="bi-house-door-fill"
                  class="hover:bg-pink-600 block py-2 px-4 rounded-lg mb-2 max-md:bg-pink-650 {{ request()->is('pegawai/' . $pegawai . '/dashboard') ? 'bg-pink-450 text-yellow-300' : '' }}">
                  Dashboard
              </x-pegawai-sidebar-link>

              <x-pegawai-sidebar-link 
                  href="{{ route('pegawai.' . $pegawai . '.index') }}"
                  icon="bi-eye-fill"
                  class="hover:bg-pink-600 block py-2 px-4 rounded-lg mb-2 max-md:bg-pink-650 {{ request()->is('pegawai/' . $pegawai . '-*') || request()->is('pegawai/' . $pegawai . '-detail' . '-*') ||request()->is('pegawai/' . $pegawai) ? 'bg-pink-450 text-yellow-300' : '' }}">
                  Lihat Data
              </x-pegawai-sidebar-link>
              
              <x-pegawai-sidebar-link 
                  href="{{ route('pegawai.' . $pegawai . '.create') }}"
                  icon="bi-plus-circle-fill"
                  class="hover:bg-pink-600 block py-2 px-4 rounded-lg mb-2 max-md:bg-pink-650 {{ request()->is('pegawai/' . $pegawai . '/create') ? 'bg-pink-450 text-yellow-300' : '' }}">
                  Tambah Data
              </x-pegawai-sidebar-link>
              
              <x-pegawai-sidebar-link 
                  href="{{ route('pegawai.' . $pegawai . '.update', 1) }}"
                  icon="bi-pencil-fill" 
                  class="hover:bg-pink-600 py-2 px-4 rounded-lg mb-2 max-md:bg-pink-650 {{ request()->is('pegawai/' . $pegawai . '/*/edit') ? 'bg-pink-450 text-yellow-300 block' : 'hidden' }}">
                  Ubah Data
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