<nav class="w-full bg-pink-650 flex text-white justify-between py-5 px-10 relative z-10">
    {{-- logo --}}
    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-30 ml-2 scale-90">

    <div class="flex justify-between items-center text-lg">
        {{-- Navlink --}}
        <span class="px-10">
            <a href="#">Komoditas</a>
        </span>
        <span class="px-10">
            <a href="#">Pasar</a>
        </span>
        <span class="px-10">
            <a href="#">Statistik</a>
        </span>
        <span class="px-10">
            <a href="#">Metadata</a>
        </span>
        <span class="px-10">
            <a href="#">Tentang Kami</a>
        </span>
    </div>
    {{-- Login --}}
    <select name="login" id="loginBtn" onchange="location = this.value;" class="bg-pink-650 border-white border-2 rounded-full text-center p-2">
        <option value="" selected disabled>Login</option>
        <option value="{{ route('dashboard') }}">Admin</option>
        <option value="{{ route('pegawai.disperindag.index') }}">Disperindag</option>
        <option value="{{ route('pegawai.dkpp.index') }}">DKPP</option>
        <option value="{{ route('pegawai.dtphp.index') }}">DTPHP</option>
        <option value="{{ route('pegawai.perikanan.index') }}">DP</option>
    </select>
    
</nav>