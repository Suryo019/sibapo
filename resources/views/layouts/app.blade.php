<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('/storage/img/logo-pemda.png') }}" type="image/png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('/storage/img/LogoPemda.png') }}" type="image/png">

    <link rel="stylesheet" href="{{ asset('build/assets/app-B_jcilra.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-CwY9jbiq.css') }}">
    <script type="module" src="{{ asset('build/assets/app-h9wISXzc.js') }}"></script>
    
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">

    {{-- Jquery --}}
    <script src="{{ asset('/js/jquery.min.js') }}"></script>

    {{-- ApexChart --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- GG Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    {{-- Iconify Figma --}}
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <title>@yield('title', 'Default Title')</title>
</head>
<body class="min-h-screen flex flex-col lg:flex-row">
    <div class="w-full h-screen flex justify-center lg:w-1/2 max-xl:h-[300px] max-xl:bg-gradient-to-b max-xl:from-pink-650 max-xl:from-45% max-xl:to-gray-10 max-xl:to-100%">
        <img src="{{ asset('storage/img/bg-login.png') }}" alt="Background Pink" class="w-full h-full object-cover absolute inset-0 z-0 max-xl:hidden" />

        <div class="flex flex-col justify-between max-xl:justify-center h-full pr-6 max-xl:pr-0 py-10 text-white text-center relative">
            <div>
                <!-- Logo Pemerintah -->
                <img src="{{ asset('storage/img/logo-pemda.png') }}" class="w-16 mx-auto hidden lg:block mb-20" />
    
                <!-- Selamat Datang -->
                <h2 class="text-xl lg:text-2xl font-semibold hidden lg:block mb-6">Selamat Datang</h2>
    
                <!-- Logo Cintako -->
                <div class="flex justify-center">
                    <a href="{{ route('beranda') }}">
                        <img src="{{ asset('storage/img/cintako.png') }}" class="w-32 lg:relative lg:z-20 mb-2" />
                    </a>
                </div>
                
    
                <!-- Deskripsi -->
                <p class="text-sm lg:text-base leading-relaxed max-w-sm mx-auto mt-4 lg:mt-6 hidden lg:block">
                    Sistem informasi penyusunan data kerja bahan pokok di seluruh Kabupaten Jember.
                </p>
            </div>

            <!-- Footer -->
            <div class="text-xs lg:text-lg hidden lg:block">
                Bidang Perekonomian <br />
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
document.querySelector("form").addEventListener("keydown",(function(e){"Enter"===e.key&&e.preventDefault()}));
</script>
