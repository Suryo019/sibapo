<nav class="w-full bg-pink-650 flex text-white justify-between items-center py-5 px-4 relative z-10">
    {{-- Logo --}}
    <img src="{{ asset('storage/img/logo.png') }}" alt="Logo" class="h-10 w-30 scale-90">

    <div class="hidden md:flex justify-between items-center text-lg">
        <span class="px-10">
            <a href="{{ route('tamu.komoditas') }}" class="{{ request()->is('komoditas') ? 'text-yellow-450 font-bold' : 'text-white' }}">Bahan Pokok</a>
        </span>
        <span class="px-10">
            <a href="{{ route('tamu.pasar.search') }}" class="{{ request()->is('pasar/search') ? 'text-yellow-450 font-bold' : 'text-white' }}">Pasar</a>
        </span>
        <span class="px-10">
            <a href="{{ route('tamu.statistik') }}" class="{{ request()->is('statistik') ? 'text-yellow-450 font-bold' : 'text-white' }}">Statistik</a>
        </span>
        <span class="px-10">
            <a href="{{ route('tamu.metadata') }}" class="{{ request()->is('metadata') ? 'text-yellow-450 font-bold' : 'text-white' }}">Metadata</a>
        </span>
        <span class="px-10">
            <a href="{{ route('tamu.tentang-kami') }}" class="{{ request()->is('tentang-kami') ? 'text-yellow-450 font-bold' : 'text-white' }}">Tentang Kami</a>
        </span>
    </div>

    {{-- Login --}}
    <select name="login" id="loginBtn" onchange="location = this.value;" class="hidden md:block bg-pink-650 border-white border-2 rounded-full text-center p-2">
        <option value="" selected disabled>Login</option>
        <option value="{{ route('dashboard') }}">Admin</option>
        <option value="{{ route('pegawai.disperindag.index') }}">Disperindag</option>
        <option value="{{ route('pegawai.dkpp.index') }}">DKPP</option>
        <option value="{{ route('pegawai.dtphp.index') }}">DTPHP</option>
        <option value="{{ route('pegawai.perikanan.index') }}">DP</option>
    </select>

    {{-- Hamburger --}}
    <button onclick="toggleMobileMenu()" class="md:hidden text-white focus:outline-none w-12 flex flex-col items-end gap-[0.35rem]">
        <div class="w-full h-1 bg-white rounded-full"></div>
        <div class="w-1/2 h-1 bg-white rounded-full"></div>
        <div class="w-2/3 h-1 bg-white rounded-full"></div>
        
        {{-- <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg> --}}
    </button>
</nav>

{{-- Mobile --}}
<div id="black_screen" class="fixed inset-0 bg-black bg-opacity-80 z-40 hidden opacity-0 transition-opacity duration-300"></div>

<div id="mobileMenu" class="fixed top-0 right-0 h-full w-3/4 bg-white text-black z-50 transform translate-x-full transition-transform duration-300 md:hidden shadow-lg">
    <div class="flex justify-between items-center p-4 border-gray-200">
        <img src="{{ asset('storage/img/logo-2.png') }}" class="h-10 w-30 scale-90" alt="Logo" class="h-8">
        <button onclick="toggleMobileMenu()" class="text-2xl text-pink-600 font-bold">&times;</button>
    </div>
    <div class="flex flex-col gap-8 px-8 py-4 text-base font-medium">
        <a href="{{ route('tamu.komoditas') }}" class="{{ request()->is('komoditas') ? 'text-pink-650 font-semibold' : '' }}">Bahan Pokok</a>
        <a href="{{ route('tamu.pasar.search') }}" class="{{ request()->is('pasar/search') ? 'text-pink-650 font-semibold' : '' }}">Pasar</a>
        <a href="{{ route('tamu.statistik') }}" class="{{ request()->is('statistik') ? 'text-pink-650 font-semibold' : '' }}">Statistik</a>
        <a href="{{ route('tamu.metadata') }}" class="{{ request()->is('metadata') ? 'text-pink-650 font-semibold' : '' }}">Metadata</a>
        <a href="{{ route('tamu.tentang-kami') }}" class="{{ request()->is('tentang-kami') ? 'text-pink-650 font-semibold' : '' }}">Tentang Kami</a>

        <select name="loginMobile" onchange="location = this.value;" class="bg-white border border-pink-600 rounded-full text-center py-2">
            <option value="" selected disabled>Login</option>
            <option value="{{ route('dashboard') }}">Admin</option>
            <option value="{{ route('pegawai.disperindag.index') }}">Disperindag</option>
            <option value="{{ route('pegawai.dkpp.index') }}">DKPP</option>
            <option value="{{ route('pegawai.dtphp.index') }}">DTPHP</option>
            <option value="{{ route('pegawai.perikanan.index') }}">DP</option>
        </select>
    </div>
</div>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const blackScreen = $('#black_screen');

        blackScreen.toggleClass('hidden');
        blackScreen.toggleClass('opacity-0');
        menu.classList.toggle('translate-x-full');
        menu.classList.toggle('translate-x-0');
    }
</script>
