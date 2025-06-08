<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('/storage/img/LogoPemda.png') }}" type="image/png">

    {{-- SweetAlert2 --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', 'Default Title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col lg:flex-row">
    <div class="w-full h-screen flex justify-center lg:w-1/2 max-xl:h-[300px] max-xl:bg-gradient-to-b max-xl:from-pink-650 max-xl:from-45% max-xl:to-gray-10 max-xl:to-100%">
        <img src="{{ asset('storage/img/bg-login.jpg') }}" alt="Background Pink" class="w-full h-full object-cover absolute inset-0 z-0 max-xl:hidden" />

        <div class="flex flex-col justify-between max-xl:justify-center h-full pr-6 max-xl:pr-0 py-10 text-white text-center relative">
            <div>
                <!-- Logo Pemerintah -->
                <img src="{{ asset('storage/img/LogoPemda.png') }}" class="w-20 mx-auto hidden lg:block mb-10" />
    
                <!-- Selamat Datang -->
                <h2 class="text-xl lg:text-2xl font-semibold hidden lg:block mb-10">Selamat Datang</h2>
    
                <!-- Logo Cintako -->
                <div class="flex justify-center">
                    <a href="{{ route('beranda') }}">
                        <img src="{{ asset('storage/img/cintako.png') }}" class="w-40 lg:w-40 lg:relative lg:z-20 mb-10" />
                    </a>
                </div>
                
    
                <!-- Deskripsi -->
                <p class="text-sm lg:text-base leading-relaxed max-w-sm mx-auto mt-4 lg:mt-6 hidden lg:block">
                Semua dicintai fawait.<br />
                Sistem Informasi Bahan Pokok Penyusunan data kerja bahan peran di seluruh Kabupaten Jember, dengan pembaruan yang dilakukan setiap hari.
                </p>
            </div>

            <!-- Footer -->
            <div class="text-xs lg:text-lg hidden lg:block">
                Bagian Tata Pemerintahan Setda<br />
                Kabupaten Jember
            </div>
        </div>
    </div>
    <div class="h-screen max-xl:h-auto w-full flex justify-center right-6 max-xl:right-0 max-xl:top-[17rem] max-xl:bg-white absolute">
        <img src="{{ asset('storage/img/awan-login.png') }}" alt="Login Design" class="h-full max-xl:hidden">
        <img src="{{ asset('storage/img/awan-login-mobile.png') }}" alt="Login Design" class="xl:hidden relative -top-20">
    </div>

    @yield('content')
</body>
</html>

<script>

document.querySelector('form').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
    }
});

</script>
