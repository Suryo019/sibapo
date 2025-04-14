{{-- @dd(request()->is('dashboard')) --}}

<aside {{ $attributes }}>
  <div class="mb-7 w-full flex justify-center">
    <img src="/img/WhatsApp Image 2025-04-03 at 12.16.37_3e08b726.jpg" 
    alt="logo" class="h-10 w-30 ml-4">  <!-- Tambah margin kiri -->
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
            <x-slot:createData>Tambah Data</x-slot:createData>
            <x-slot:createData href="{{ route('dtphp.create') }}">Tambah Data</x-slot:createData>
            <x-slot:viewData href="{{ route('dtphp.index') }}">Lihat Data</x-slot:viewData>
        </x-admin-sidebar-link>
  
        <!-- PERIKANAN -->
        <x-admin-sidebar-link href="perikanan">
            <x-slot:name>PERIKANAN</x-slot:name>
            <x-slot:createData>Tambah Data</x-slot:createData>
            <x-slot:createData href="{{ route('perikanan.create') }}">Tambah Data</x-slot:createData>
            <x-slot:viewData href="{{ route('perikanan.index') }}">Lihat Data</x-slot:viewData>
        </x-admin-sidebar-link>
      </ul>
    </nav>
</aside>