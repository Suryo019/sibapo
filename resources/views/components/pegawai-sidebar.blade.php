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
    <h2 class="md:hidden text-green-950 font-medium mb-3">Menu</h2>
    <div class="mb-5 justify-center hidden md:flex">
        <div class="mb-5 justify-center hidden md:flex">
            <img class="scale-50 ml-4" src="{{ asset('img/WhatsApp Image 2025-04-03 at 12.16.37_3e08b726.jpg') }}" alt="logo">
        </div>
    </div>
    <nav>
        <ul>
            <x-pegawai-sidebar-link 
                href="{{ route('pegawai.' . $pegawai . '.dashboard') }}" 
                class="block py-2 px-4 rounded {{ request()->is('pegawai/' . $pegawai . '/dashboard') ? 'bg-green-600' : '' }}">
                Dashboard
            </x-pegawai-sidebar-link>

            <x-pegawai-sidebar-link 
                href="{{ route('pegawai.' . $pegawai . '.index') }}" 
                class="block py-2 px-4 rounded {{ request()->is('pegawai/' . $pegawai) || request()->is('pegawai/' . $pegawai . '-detail') ? 'bg-green-600' : '' }}">
                Lihat Data
            </x-pegawai-sidebar-link>
            
            <x-pegawai-sidebar-link 
                href="{{ route('pegawai.' . $pegawai . '.create') }}" 
                class="block py-2 px-4 rounded {{ request()->is('pegawai/' . $pegawai . '/create') ? 'bg-green-600' : '' }}">
                Tambah Data
            </x-pegawai-sidebar-link>
            
            <x-pegawai-sidebar-link 
                href="{{ route('pegawai.' . $pegawai . '.update', 1) }}" 
                class="py-2 px-4 rounded {{ request()->is('pegawai/' . $pegawai . '/*/edit') ? 'bg-green-600 block' : 'hidden' }}">
                Ubah Data
            </x-pegawai-sidebar-link>            
        </ul>
    </nav>
</aside>