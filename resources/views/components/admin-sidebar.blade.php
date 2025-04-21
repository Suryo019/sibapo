{{-- @dd(request()->is('dashboard')) --}}

<aside {{ $attributes }}>
    <h2 class="md:hidden text-green-950 font-medium mb-3">Menu</h2>
    <div class="mb-5 justify-center hidden md:flex">
      <img class="scale-50 ml-4" src="{{ asset('img/WhatsApp Image 2025-04-03 at 12.16.37_3e08b726.jpg') }}" alt="logo">
    </div>
    <nav>
      <ul>
        <!-- Dashboard -->
        <li class="mb-2 rounded-md bg-green-900 md:bg-transparent">
          <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded {{ request()->is('dashboard') ? 'text-yellow-300' : '' }}">Dashboard</a>
        </li>
  
        <!-- DISPERINDAG -->
        <x-admin-sidebar-link dataHref="disperindag*">
            <x-slot:name>DISPERINDAG</x-slot:name>
            <x-slot:createData href="{{ route('disperindag.create') }}">Tambah Data</x-slot:createData>
            <x-slot:viewData href="{{ route('disperindag.index') }}">Lihat Data</x-slot:viewData>
        </x-admin-sidebar-link>
  
        <!-- DKPP -->
        <x-admin-sidebar-link dataHref="dkpp*">
            <x-slot:name>DKPP</x-slot:name>
            <x-slot:createData href="{{ route('dkpp.create') }}">Tambah Data</x-slot:createData>
            <x-slot:viewData href="{{ route('dkpp.index') }}">Lihat Data</x-slot:viewData>
        </x-admin-sidebar-link>
  
        <!-- DTPHP -->
        <x-admin-sidebar-link dataHref="dtphp*">
            <x-slot:name>DTPHP</x-slot:name>
            <x-slot:createData href="{{ route('dtphp.create') }}">Tambah Data</x-slot:createData>
            <x-slot:viewData href="{{ route('dtphp.produksi') }}">Lihat Data</x-slot:viewData>
        </x-admin-sidebar-link>
  
        <!-- PERIKANAN -->
        <x-admin-sidebar-link dataHref="perikanan*">
            <x-slot:name>PERIKANAN</x-slot:name>
            <x-slot:createData href="{{ route('perikanan.create') }}">Tambah Data</x-slot:createData>
            <x-slot:viewData href="{{ route('perikanan.index') }}">Lihat Data</x-slot:viewData>
        </x-admin-sidebar-link>
      </ul>
    </nav>
</aside>