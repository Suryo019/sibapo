@php
$judul = match(true) {
    request()->is('pegawai/disperindag*') => 'DISPERINDAG',
    request()->is('pegawai/dkpp*') => 'DKPP',
    request()->is('pegawai/dtphp*') => 'DTPHP',
    request()->is('pegawai/perikanan*') => 'PERIKANAN',
    default => 'DASHBOARD'
};
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Token CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('/storage/img/logo-pemda.png') }}" type="image/png">

    <title>{{ $title ? $title . ' | Cintako' : 'DISPERINDAG'  }}</title>
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
<body class="w-screen h-screen overflow-hidden">
      <!-- Loading overlay -->
      <div id="loading" class="fixed w-full h-full bg-black bg-opacity-50 z-50" style="display: none;">
        <div class="w-full h-full flex items-center justify-center flex-col">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-yellow-400 border-solid mx-auto"></div>
            <p class="mt-4 text-gray-700 text-center">Loading, please wait...</p>
        </div>
    </div>

    <!-- Content Area (Scrollable) -->
    <div class="h-full w-full pl-[22rem] overflow-y-auto py-5 pr-10 relative z-10 max-md:px-0 max-md:order-1 max-md:pt-0">
        <x-pegawai-header class="text-black flex justify-between items-center h-16 mb-7 max-md:px-4 max-md:bg-pink-650 max-md:mb-4">
            {{ $judul }}
        </x-pegawai-header>

        <!-- Sidebar (Fixed) -->
        <x-pegawai-sidebar class="w-[22rem] fixed left-0 top-0 h-screen max-md:h-auto px-10 py-5 z-30 max-md:hidden max-md:w-full max-md:static max-md:order-2 max-md:px-7 max-md:py-0 max-md:mb-10" id="sidebar">
        </x-pegawai-sidebar>
        
        <main class="max-md:px-3">
            {{ $slot }}
        </main>
    </div>

    {{-- BG --}}
    <div class="w-full h-screen fixed z-0 overflow-hidden">
        <img src="{{ asset('/storage/img/kembang-sidebar-2.png') }}" class="fixed bottom-5 scale-95 -right-28" alt="">
    </div>

    <script>
$(document).ready((function(){$(".select2").select2()})),document.querySelector("form").addEventListener("keydown",(function(e){"Enter"===e.key&&e.preventDefault()}));const API_TOKEN="{{ session('api_token') }}";function showLoading(){document.getElementById("loading").style.display="flex"}function hideLoading(){document.getElementById("loading").style.display="none"}$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content"),Authorization:"Bearer "+API_TOKEN}}),$(document).ajaxStart((function(){$("#loading").show()})).ajaxStop((function(){$("#loading").hide()}));
    </script>
    
</body>
</html>
