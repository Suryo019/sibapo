<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Beranda</title>
    {{-- <link rel="stylesheet" href="../src/output.css"> --}}
    @vite('resources/css/app.css')

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- Bootstrap Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- SweetAlert2 --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ApexChart --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- GG Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    {{-- Iconify Figma --}}
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

</head>
<body class="h-screen w-screen overflow-hidden">

    {{-- Navigasi --}}
    <x-tamu-navbar></x-tamu-navbar>

    {{-- Body Content --}}

    <script>
        // Select2
        $(document).ready(function() {
            $('.select2').select2();
        });
        function showLoading() {
            document.getElementById("loading").style.display = "flex";
        }

        function hideLoading() {
            document.getElementById("loading").style.display = "none";
        }

        $(document)
            .ajaxStart(function () {
                $("#loading").show();
            })
            .ajaxStop(function () {
                $("#loading").hide();
        });
    </script>
    
</body>
</html>
