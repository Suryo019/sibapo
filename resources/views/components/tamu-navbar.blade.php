<nav class="w-full bg-pink-650 flex text-white justify-between items-center px-4 sm:px-6 lg:px-8 py-3 lg:py-4 fixed z-40">
    {{-- Logo --}}
    <a href="{{ route('beranda') }}" class="flex items-center flex-shrink-0">
        <img class="w-28 md:w-36" src="{{ asset('storage/img/logo-cintako.png') }}" alt="logo">
    </a>
    
    {{-- Desktop Menu --}}
    <div class="hidden lg:flex space-x-2 xl:space-x-8 items-center text-base xl:text-lg">
        <a href="{{ route('beranda') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->is('/') ? 'text-yellow-450 font-semibold' : 'text-white' }}">Beranda</a>
        <a href="{{ route('tamu.komoditas') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->is('komoditas') ? 'text-yellow-450 font-semibold' : 'text-white' }}">Bahan Pokok</a>
        <a href="{{ route('tamu.pasar.search') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->is('pasar/search') ? 'text-yellow-450 font-semibold' : 'text-white' }}">Pasar</a>
        <a href="{{ route('tamu.statistik') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->is('statistik') ? 'text-yellow-450 font-semibold' : 'text-white' }}">Statistik</a>
        <a href="{{ route('tamu.metadata') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->is('metadata') ? 'text-yellow-450 font-semibold' : 'text-white' }}">Metadata</a>
        <a href="{{ route('tamu.tentang-kami') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->is('tentang-kami') ? 'text-yellow-450 font-semibold' : 'text-white' }}">Tentang Kami</a>
    </div>

    {{-- Login/Dashboard Button --}}
    @php
        $userRole = Auth::check() ? Auth::user()->role->role : null;
    @endphp
    <div class="hidden lg:block ml-4">
        @auth
            @php
                $dashboardRoutes = [
                    'admin' => 'dashboard',
                    'pimpinan' => 'pimpinan.dashboard',
                    'disperindag' => 'pegawai.disperindag.dashboard',
                    'dkpp' => 'pegawai.dkpp.dashboard',
                    'dtphp' => 'pegawai.dtphp.dashboard',
                    'perikanan' => 'pegawai.perikanan.dashboard'
                ];
            @endphp
            <a href="{{ route($dashboardRoutes[$userRole] ?? '#') }}" class="bg-pink-500 hover:bg-pink-600 border-2 border-white rounded-full px-4 py-2 text-sm xl:text-base transition-colors">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="flex items-center gap-2 bg-pink-500 hover:bg-pink-600 border-2 border-white rounded-full px-4 py-2 text-sm xl:text-base transition-colors">
                <iconify-icon icon="material-symbols:login" class="text-xl"></iconify-icon>
                Login
            </a>
        @endauth
    </div>

    {{-- Mobile Menu Button --}}
    <button onclick="toggleMobileMenu()" class="lg:hidden flex flex-col items-end gap-1.5 w-10 focus:outline-none">
        <span class="block w-8 h-0.5 bg-white rounded-full transition-all"></span>
        <span class="block w-6 h-0.5 bg-white rounded-full transition-all"></span>
        <span class="block w-4 h-0.5 bg-white rounded-full transition-all"></span>
    </button>
</nav>

<div class="w-full bg-pink-650 flex text-white justify-around max-md:justify-between items-center max-md:px-6 py-5 mb-10"></div>

{{-- Mobile --}}
<div id="black_screen" class="fixed inset-0 bg-black bg-opacity-80 z-40 hidden opacity-0 transition-opacity duration-300"></div>

<div id="mobileMenu" class="fixed top-0 right-0 h-full w-3/4 bg-white text-black z-50 transform translate-x-full transition-transform duration-300 lg:hidden shadow-lg">
    <div class="flex justify-between items-center p-4 border-gray-200 bg-pink-650">
        <img src="{{ asset('storage/img/logo-cintako.png') }}" class="h-12 w-30 scale-90" alt="Logo" class="h-8">
        <button onclick="toggleMobileMenu()" class="text-2xl text-white font-bold">&times;</button>
    </div>
    <div class="flex flex-col gap-8 px-8 py-4 text-base font-medium">
        <a href="{{ route('beranda') }}" class="{{ request()->is('/') ? 'text-pink-650 font-semibold' : '' }}">Beranda</a>
        <a href="{{ route('tamu.komoditas') }}" class="{{ request()->is('komoditas') ? 'text-pink-650 font-semibold' : '' }}">Bahan Pokok</a>
        <a href="{{ route('tamu.pasar.search') }}" class="{{ request()->is('pasar/search') ? 'text-pink-650 font-semibold' : '' }}">Pasar</a>
        <a href="{{ route('tamu.statistik') }}" class="{{ request()->is('statistik') ? 'text-pink-650 font-semibold' : '' }}">Statistik</a>
        <a href="{{ route('tamu.metadata') }}" class="{{ request()->is('metadata') ? 'text-pink-650 font-semibold' : '' }}">Metadata</a>
        <a href="{{ route('tamu.tentang-kami') }}" class="{{ request()->is('tentang-kami') ? 'text-pink-650 font-semibold' : '' }}">Tentang Kami</a>

        @auth    
            @switch($userRole)
                @case('admin')
                    <a href="{{ route('dashboard') }}" class="bg-white border border-pink-600 rounded-full text-center py-2">Dashboard</a>
                    @break

                @case('pimpinan')
                    <a href="{{ route('pimpinan.dashboard') }}" class="bg-white border border-pink-600 rounded-full text-center py-2">Dashboard</a>
                    @break

                @case('disperindag')
                    <a href="{{ route('pegawai.disperindag.dashboard') }}" class="bg-white border border-pink-600 rounded-full text-center py-2">Dashboard</a>
                    @break

                @case('dkpp')
                    <a href="{{ route('pegawai.dkpp.dashboard') }}" class="bg-white border border-pink-600 rounded-full text-center py-2">Dashboard</a>
                    @break

                @case('dtphp')
                    <a href="{{ route('pegawai.dtphp.dashboard') }}" class="bg-white border border-pink-600 rounded-full text-center py-2">Dashboard</a>
                    @break

                @case('perikanan')
                    <a href="{{ route('pegawai.perikanan.dashboard') }}" class="bg-white border border-pink-600 rounded-full text-center py-2">Dashboard</a>
                    @break
            @endswitch
        @else
            <a href="{{ route('login') }}" class="bg-white border border-pink-600 rounded-full text-center py-2">Login</a>
        @endauth
    </div>
</div>

<script>
function toggleMobileMenu(){const e=document.getElementById("mobileMenu"),l=$("#black_screen");l.toggleClass("hidden"),l.toggleClass("opacity-0"),e.classList.toggle("translate-x-full"),e.classList.toggle("translate-x-0")}
</script>
