<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="{{ asset('/storage/img/logo-pemda.png') }}" type="image/png">

    <title>{{ $title ? $title . ' | Cintako' : 'Beranda | Cintako' }}</title>

    {{-- <link rel="stylesheet" href="../src/output.css"> --}}
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

    <link href="{{ asset('js/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/select2/dist/js/select2.min.js') }}"></script>

</head>
<body class="h-screen w-screen overflow-x-hidden scrollbar-thin">
    <!-- Loading overlay -->
    {{-- <div id="loading" class="fixed w-full h-full bg-black bg-opacity-50 z-50" style="display: none;">
        <div class="w-full h-full flex items-center justify-center flex-col">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-yellow-450 border-solid mx-auto"></div>
            <p class="mt-4 text-gray-700 text-center">Loading, please wait...</p>
        </div>
    </div> --}}

    {{-- BG wkwk --}}
    <div class="w-full h-full fixed z-0">
        <div class="w-[30%] h-[45%] bg-pink-650 absolute rounded-full blur-3xl opacity-25 top-0 right-0"></div>
        <div class="w-[30%] h-[45%] bg-pink-650 absolute rounded-full blur-3xl opacity-25 bottom-0 left-0"></div>
    </div>

    {{-- Navigasi --}}
    <x-tamu-navbar></x-tamu-navbar>

    {{-- footer --}}
    <main class="w-full h-auto relative z-10 py-20">
        {{ $slot }}
    </main>

    {{-- footer --}}
    {{-- <footer class="w-full h-80 bg-black relative z-10 bottom-0"></footer> --}}
    <x-tamu-footer></x-tamu-footer>

    
    <script>
function showLoading(){document.getElementById("loading").style.display="flex"}function hideLoading(){document.getElementById("loading").style.display="none"}$(document).ready((function(){$(".select2").select2()})),$(document).ajaxStart((function(){$("#loading").show()})).ajaxStop((function(){$("#loading").hide()}));
    </script>
    
</body>
</html>
