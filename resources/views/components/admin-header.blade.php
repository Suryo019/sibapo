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
            <i class="bi bi-bell-fill text-gray-600 cursor-pointer text-2xl" id="notifToggle"></i>

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
        <div class="flex items-center gap-4 cursor-pointer" id="profile-toggler">     
            <img src="{{ asset('storage/img/placeholder.png') }}" alt="Profile"
                 class="w-10 h-10 rounded-full bg-gray-300 scale-95 md:scale-100">
            <span class="text-sm hidden md:block">Hi, saya ini</span>
        </div>
    </div>
</header>

<!-- Background dark layer -->
<div id="bg-darker"
    class="w-screen h-screen bg-black/70 fixed top-0 left-0 z-40 opacity-0 pointer-events-none transition-opacity duration-500">
</div>

<!-- Sliding profile page -->
{{-- <div id="profile-web-page"
    class="fixed w-full h-full overflow-y-auto top-0 left-0 z-50 bg-cover p-8 transition-all duration-500 ease-in-out"
    style="background-image: url('/storage/img/profile-page-bg.png');"> --}}
<div id="profile-web-page" class="fixed w-full h-full overflow-y-auto top-[-100%] left-0 z-50 bg-cover transition-all duration-500 ease-in-out bg-white">
    <img src="{{ asset('/storage/img/profile-page-bg-fix.png') }}" alt="profile" class="w-full absolute z-0">
    
    <div class="relative z-10 h-auto p-8">
        <div class="flex items-center w-fit gap-2 text-white cursor-pointer mb-5" id="profile-back-toggler">
            <iconify-icon icon="mingcute:left-fill" class="text-5xl"></iconify-icon>
            {{-- <span class="text-2xl">KEMBALI</span> --}}
        </div>
        
        <form class="w-full h-full flex flex-col items-center" method="POST" action="#" enctype="multipart/form-data">
            @csrf
            <div class="w-64 h-64 rounded-full shadow-white-custom border-white border-4 mb-4 relative">
                <img src="{{ asset('/storage/img/placeholder.png') }}" alt="Profile Image" class="rounded-full w-full h-full object-cover">

                <input type="file" name="gambar" id="gambar" hidden>

                <button type="button" id="btn-upload" class="w-20 h-20 bg-pink-650 rounded-full absolute bottom-0 right-0 flex items-center justify-center text-white">
                    <iconify-icon icon="solar:camera-broken" class="text-5xl"></iconify-icon>
                </button>
            </div>


            {{-- Name & role --}}
            <div class="flex flex-col items-center gap-3 mb-10">
                <div class="text-4xl flex items-center gap-3 font-semibold text-pink-650">
                    Raden Sugeng Dalu
                    <iconify-icon icon="heroicons:pencil-square-solid" class="text-gray-550 text-xl cursor-pointer"></iconify-icon>
                </div>
                <div class="text-black text-xl">Admin</div>
            </div>

            {{-- Username & email --}}
            <div class="w-3/12 mb-4">
                <label for="username" class="flex items-center text-pink-650 text-xl font-semibold mb-2 gap-2">
                    <i class="bi bi-person-fill"></i>
                    Username
                </label>
                <div class="w-full bg-gray-90 rounded-full flex items-center">
                    <input type="text" class="w-11/12 py-2 px-4 rounded-full outline-none text-gray-550" disabled placeholder="Username" value="brbrpatapim" id="username" name="username">
                    <iconify-icon icon="heroicons:pencil-square-solid" class="w-1/12 text-gray-550 text-xl cursor-pointer"></iconify-icon>
                </div>
            </div>

            <div class="w-3/12 mb-10">
                <label for="email" class="flex items-center text-pink-650 text-xl font-semibold mb-2 gap-2">
                    <i class="bi bi-envelope-fill"></i>
                    Email
                </label>
                <input type="text" class="w-full py-2 px-4 rounded-full outline-none text-gray-550" disabled placeholder="Email" value="user@example.com" id="email" name="email">
            </div>
            <button type="button" class="w-32 mb-28 p-2 bg-pink-650 rounded-full text-white flex justify-center items-center">Simpan</button>

            <button class="w-2/12 p-2 mb-8 bg-red-500 rounded-full text-white flex justify-center items-center">
                Log Out
            </button>
        </form>
    </div>
</div>


<script>
    // Profile Image Clicker
    $(document).on('click', '#btn-upload', function() {
        $('#gambar').click();
    });

    // Profile Web Page Toggler
    $(document).on('click', '#profile-toggler', function () {
        $('#bg-darker')
            .removeClass('pointer-events-none')
            .addClass('pointer-events-auto')
            .addClass('opacity-100')
            .removeClass('opacity-0');

        $('#profile-web-page')
            .removeClass('top-[-100%]')
            .addClass('top-0');
    });

    $(document).on('click', '#profile-back-toggler', function () {
        $('#profile-web-page')
            .removeClass('top-0')
            .addClass('top-[-100%]');

        $('#bg-darker')
            .removeClass('opacity-100')
            .addClass('opacity-0')
            .one('transitionend', function () {
                $(this)
                    .addClass('pointer-events-none')
                    .removeClass('pointer-events-auto');
            });
    });


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