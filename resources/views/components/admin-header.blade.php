<header class="bg-green-900 text-white p-4 flex justify-between items-center w-full z-9">
    <h2 class="text-lg font-semibold text-center">{{ $slot }}</h2>
    
    <div class="flex items-center gap-4 mr-4"> <!-- Tambah margin kanan -->
        <img src="https://via.placeholder.com/40" alt="Profile" 
             class="w-10 h-10 rounded-full bg-gray-300">
        <span class="text-sm">Hi, saya ini</span>
    </div>
</header>