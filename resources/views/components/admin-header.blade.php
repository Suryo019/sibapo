<header {{ $attributes }}>

    <div class="flex md:hidden items-center">
        <div class="flex justify-center items-center text-green-900 bg-white rounded w-6 h-6 cursor-pointer" id="burger-menu">
            <i class="bi bi-list text-xl"></i>
        </div>
        {{-- Logo --}}
        <div class="justify-center flex md:hidden">
            <img src="{{ asset('/img/WhatsApp Image 2025-04-03 at 12.16.37_3e08b726.jpg') }}" 
            alt="logo" class="h-10 w-30 ml-2 scale-90">
        </div>
    </div>

    {{-- Nama Dinas --}}
    <h2 class="text-lg font-semibold text-center hidden md:block">{{ $slot }}</h2>
    
    <div class="flex items-center gap-4 mr-4"> <!-- Tambah margin kanan -->
        <img src="https://via.placeholder.com/40" alt="Profile" 
             class="w-10 h-10 rounded-full bg-gray-300 scale-95 md:scale-100">
        <span class="text-sm hidden md:block">Hi, saya ini</span>
    </div>
</header>

<script>

$('#burger-menu').on('click', function() {
    $('#sidebar')
        .removeClass('hidden')
        .toggleClass('hidden')
        .slideToggle('slow');
});

</script>