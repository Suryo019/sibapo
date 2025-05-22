<header {{ $attributes }}>

    <div class="flex md:hidden items-center">
        <div class="flex justify-center items-center text-green-900 bg-white rounded w-6 h-6 cursor-pointer" id="burger-menu">
            <i class="bi bi-list text-xl"></i>
        </div>
        {{-- Logo --}}
        <div class="justify-center flex md:hidden">
            <img src="{{ asset('/img/logo.png') }}" 
            alt="logo" class="h-10 w-30 ml-2 scale-90">
        </div>
    </div>

    {{-- Nama Dinas --}}
    <h2 class="text-2xl font-extrabold text-center hidden md:block">{{ $slot }}</h2>
    
    <div class="flex items-center gap-4 mr-4">
        <!-- Icon Notifikasi -->
<div class="relative mr-4">
    <iconify-icon id="notifToggle" icon="ion:notifications" width="24" height="24" class="text-gray-600 cursor-pointer"></iconify-icon>

    <!-- Dropdown Notifikasi -->
    <div id="notifPanel" class="hidden absolute right-0 top-8 w-96 bg-white shadow-lg rounded-2xl z-50 p-5">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Notifikasi</h3>
            <button id="notifClose" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        </div>

        <div>
            <p class="font-semibold mb-2">Hari ini</p>

            <!-- Notifikasi 1 -->
            <div class="flex items-start p-3 mb-2 border rounded-lg border-pink-300">
                <img src="https://via.placeholder.com/30" alt="Icon" class="w-7 h-7 mr-3">
                <div>
                    <p class="text-sm text-pink-600 font-bold">DISPERINDAG</p>
                    <p class="text-sm text-gray-600">Belum menginputkan data untuk periode ini.</p>
                    <span class="text-xs text-gray-400">Baru saja</span>
                </div>
            </div>

            <!-- Tambah notifikasi lainnya sesuai kebutuhan -->
        </div>

        <p class="text-center text-pink-600 mt-4 cursor-pointer hover:underline">Semua Notifikasi</p>
    </div>
</div>


        <!-- Gambar Profil dan Nama -->
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

//notifikasi
    // Toggle panel notifikasi
    $('#notifToggle').on('click', function () {
        $('#notifPanel').toggleClass('hidden');
    });

    // Tombol close
    $('#notifClose').on('click', function () {
        $('#notifPanel').addClass('hidden');
    });

    // Klik di luar panel akan menutup
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#notifToggle, #notifPanel').length) {
            $('#notifPanel').addClass('hidden');
        }
    });

    // Sidebar
    $('#burger-menu').on('click', function () {
        $('#sidebar')
            .removeClass('hidden')
            .toggleClass('hidden')
            .slideToggle('slow');
    });

</script>