@php
$pegawai = match(true) {
    request()->is('pegawai/disperindag*') => 'disperindag',
    request()->is('pegawai/dkpp*') => 'dkpp',
    request()->is('pegawai/dtphp*') => 'dtphp',
    request()->is('pegawai/dp*') => 'dp',
};
@endphp

<!-- Sidebar -->
<aside {{ $attributes }}>
    <div class="mb-7 w-full flex justify-center">
        <img src="/img/WhatsApp Image 2025-04-03 at 12.16.37_3e08b726.jpg" 
        alt="logo" class="h-10 w-30 ml-4">  <!-- Tambah margin kiri -->
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