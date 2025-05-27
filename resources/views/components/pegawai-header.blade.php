<header {{ $attributes }}>
    <div class="flex md:hidden items-center w-2/3">
        <div class="flex justify-center items-center text-green-900 bg-white rounded w-7 h-6 cursor-pointer" id="burger-menu">
            <i class="bi bi-list text-xl"></i>
        </div>
        {{-- Nama Dinas (<= MD) --}}
        <div class="justify-center flex md:hidden ml-4">
            <h1 class="text-lg font-extrabold text-white">{{ $slot }}</h1>
        </div>
    </div>

    {{-- Nama Dinas --}}
    <h2 class="text-2xl font-extrabold text-center hidden md:block">{{ $slot }}</h2>
    
    <!-- Gambar Profil dan Nama -->
    <div class="flex items-center gap-4 cursor-pointer" id="profile-toggler">     
        <img src="{{ asset('storage/img/placeholder.png') }}" alt="Profile"
             class="w-10 h-10 rounded-full bg-gray-300 scale-95 md:scale-100">
        <span class="text-sm hidden md:block">Hi, saya ini</span>
    </div>
</header>

<!-- Background dark layer -->
<div id="bg-darker"
    class="w-screen h-screen bg-black/70 fixed top-0 left-0 z-40 opacity-0 pointer-events-none transition-opacity duration-500">
</div>

<!-- Sliding profile page -->
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

        </form>

        <form class="w-full h-full flex flex-col items-center" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-2/12 p-2 mb-8 bg-red-500 rounded-full text-white flex justify-center items-center">
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
</script>