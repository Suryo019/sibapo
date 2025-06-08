<aside {{ $attributes }}>
    <nav class="bg-pink-650 w-full h-full rounded-[30px] max-md:rounded-none flex flex-col place-content-between text-white font-medium shadow-pink-custom max-md:shadow-none overflow-hidden max-md:bg-transparent">
      <div class="bg-pink-650 max-md:bg-transparent rounded-xl relative z-10">
        {{-- Header --}}
        <h2 class="md:hidden font-medium mb-3 text-black">Menu</h2>
        <div class="mb-5 justify-center mt-1 hidden md:flex">
          <img class="w-12 ml-4" src="{{ asset('storage/img/LogoPemda.png') }}" alt="logo">
          <img class="w-14  ml-4" src="{{ asset('storage/img/logo_1.png') }}" alt="logo">
        </div>
  
        {{-- Link --}}
        <ul class="">
          <!-- Dashboard -->
          <li class="hover:bg-pink-600 block py-2 px-4 rounded-lg mb-2 max-md:bg-pink-650 {{ request()->is('pimpinan/dashboard') ? 'bg-pink-450 text-yellow-300' : '' }}">
            <a href="{{ route('pimpinan.dashboard') }}" class="pl-4 gap-5 w-full flex items-center">
              <iconify-icon icon="bi:house-door-fill" class="text-xl"></iconify-icon>
              Dashboard
            </a>
          </li>
          
          <x-pimpinan-sidebar-link
                href="{{ route('pimpinan.disperindag')}}"
                class="hover:bg-pink-600 block py-2 px-4 rounded-lg mb-2 max-md:bg-pink-650 {{ request()->is('pimpinan/disperindag') ? 'bg-pink-450 text-yellow-300' : '' }}">
                <iconify-icon icon="mage:basket-fill" class="text-xl"></iconify-icon>
                DISPERINDAG
          </x-pimpinan-sidebar-link>

          <x-pimpinan-sidebar-link
                href="{{ route('pimpinan.dkpp')}}"
                class="hover:bg-pink-600 block py-2 px-4 rounded-lg mb-2 max-md:bg-pink-650 {{ request()->is('pimpinan/dkpp') ? 'bg-pink-450 text-yellow-300' : '' }}">
                <iconify-icon icon="healthicons:plantation-worker-alt" class="text-xl"></iconify-icon>
                DKPP
          </x-pimpinan-sidebar-link>

          <x-pimpinan-sidebar-link
                href="{{ route('pimpinan.dtphp-volume')}}"
                class="hover:bg-pink-600 block py-2 px-4 rounded-lg mb-2 max-md:bg-pink-650 {{ request()->is('pimpinan/dtphp-volume') ? 'bg-pink-450 text-yellow-300' : '' }}">
                <iconify-icon icon="carbon:agriculture-analytics" class="text-xl"></iconify-icon>
                DTPHP 
          </x-pimpinan-sidebar-link>

          <x-pimpinan-sidebar-link
                href="{{ route('pimpinan.perikanan')}}"
                class="hover:bg-pink-600 block py-2 px-4 rounded-lg mb-2 max-md:bg-pink-650 {{ request()->is('pimpinan/perikanan') ? 'bg-pink-450 text-yellow-300' : '' }}">
                <iconify-icon icon="majesticons:fish" class="text-xl"></iconify-icon>
                Perikanan
          </x-pimpinan-sidebar-link>
  
  
          <!-- Logout -->
          <li class="mb-2 rounded-lg py-2 hover:bg-pink-600 md:bg-transparent max-md:bg-pink-650">
            <a href="{{ route('beranda') }}" class="flex items-center gap-5 text-sm pl-7 rounded-md {{ request()->is('logout') ? 'bg-pink-450' : '' }}">
              <iconify-icon icon="bi:box-arrow-left" class="text-xl"></iconify-icon>
              Beranda
            </a>
          </li>
        </ul>
      </div>
  
      {{-- Decoration --}}
      <div class="w-[18rem] h-[15rem] p-2 fixed bottom-5 max-md:hidden">
        <img src="{{ asset('storage/img/kembang_sidebar.png') }}" class="h-full bg-contain" alt="Flower">
      </div>
    </nav>
  </aside>
  