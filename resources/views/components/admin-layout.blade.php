<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    {{-- <link rel="stylesheet" href="../src/output.css"> --}}
    @vite('resources/css/app.css')

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- Bootstrap Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body class="bg-green-100 h-screen">
    <!-- Loader Overlay -->
    <div id="loader" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
      <div class="w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <!-- Header -->
    <x-admin-header></x-admin-header>
    
    <div class="h-full">
      <!-- Sidebar -->
      <x-admin-sidebar></x-admin-sidebar>
        
      <!-- Content -->
      <main class="w-full pl-64 pt-16">
        {{ $slot }}
      </main>
    </div>

    <script>
      window.addEventListener('load', function () {
        const loader = document.getElementById('loader');
        if (loader) {
          loader.classList.add('opacity-0', 'transition-opacity', 'duration-500');
          setTimeout(() => {
            loader.style.display = 'none';
          }, 500);
        }
      });
    </script>
    
</body>
</html>
