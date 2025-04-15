{{-- @dd(request()->is('dashboard')) --}}

<aside class="w-64 bg-green-900 text-white p-4 pt-24 h-screen fixed">
    <div class="w-full mb-7 flex justify-center">
      <img src="{{ asset('img/WhatsApp Image 2025-04-03 at 12.16.37_3e08b726.jpg') }}" 
      alt="logo" class="h-10 w-30 ml-4">
    </div>
    <nav>
      <ul>
        <!-- Dashboard -->
        <li class="mb-2">
          <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded {{ request()->is('dashboard') ? 'bg-green-600' : '' }}">Dashboard</a>
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
        <x-admin-sidebar-link href="dtphp">
            <x-slot:name>DTPHP</x-slot:name>
            <x-slot:createData href="{{ route('dtphp.create') }}">Tambah Data</x-slot:createData>
            <x-slot:viewData href="{{ route('dtphp.produksi') }}">Lihat Data</x-slot:viewData>
        </x-admin-sidebar-link>
  
        <!-- PERIKANAN -->
        <x-admin-sidebar-link href="perikanan">
            <x-slot:name>PERIKANAN</x-slot:name>
            <x-slot:createData href="{{ route('perikanan.create') }}">Tambah Data</x-slot:createData>
            <x-slot:viewData href="{{ route('perikanan.index') }}">Lihat Data</x-slot:viewData>
        </x-admin-sidebar-link>
      </ul>
    </nav>
</aside>