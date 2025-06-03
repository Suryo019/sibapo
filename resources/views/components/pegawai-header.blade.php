@php
    $imagePath = optional(Auth::user())->user_image 
        ? asset('storage/' . Auth::user()->user_image) 
        : asset('storage/img/placeholder.png');
@endphp

@php
    $imagePath = optional(Auth::user())->user_image 
        ? asset('storage/' . Auth::user()->user_image) 
        : asset('storage/img/placeholder.png');
@endphp

<header {{ $attributes }}>
    <!-- Kiri: Burger Menu dan Nama Dinas di Mobile -->
    <div class="flex md:hidden items-center w-2/3">
        <div id="burger-menu" class="flex justify-center items-center text-green-900 bg-white rounded w-7 h-6 cursor-pointer">
            <i class="bi bi-list text-xl"></i>
        </div>
        <div class="justify-center flex md:hidden ml-4">
            <h1 class="text-lg font-extrabold text-white">{{ $slot }}</h1>
        </div>
    </div>

    <!-- Tengah: Nama Dinas (Desktop) -->
    <h2 class="text-2xl font-extrabold text-center hidden md:block">{{ $slot }}</h2>

    @php
        $linkNotifikasi = match(true) {
            Auth::user()->role->role == 'disperindag' => route('pegawai.disperindag.notifikasi.index'),
            Auth::user()->role->role == 'dkpp' => route('pegawai.dkpp.notifikasi.index'),
            Auth::user()->role->role == 'dtphp' => route('pegawai.dtphp.notifikasi.index'),
            Auth::user()->role->role == 'perikanan' => route('pegawai.perikanan.notifikasi.index'),
            default => 'Admin'
        };
    @endphp
    <div class="flex items-center gap-4">
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
                </div>
                <a href="{{ $linkNotifikasi }}"><p class="text-center text-pink-600 mt-4 cursor-pointer hover:underline">Semua Notifikasi</p></a>
                
            </div>
        </div>
    
        <!-- Gambar Profil dan Nama -->
        <div class="flex items-center gap-4 cursor-pointer" id="profile-toggler">     
            <img src="{{ $imagePath }}" alt="Profile"
                class="w-10 h-10 rounded-full bg-gray-300 scale-95 md:scale-100">
            <span class="text-sm hidden md:block">Hi, <b class="text-yellow-500">{{ Auth::user()->username }}</b>!</span>
        </div>
    </div>

</header>


<!-- Background dark layer -->
<div id="bg-darker"
    class="w-screen h-screen bg-black/70 fixed top-0 left-0 z-40 opacity-0 pointer-events-none transition-opacity duration-500">
</div>

<!-- Sliding profile page -->
<div id="profile-web-page" class="fixed w-full h-full overflow-y-auto top-[-100%] left-0 z-50 bg-cover transition-all duration-500 ease-in-out bg-white">
    <img src="{{ asset('/storage/img/profile-page-bg-fix.png') }}" alt="profile" class="w-full absolute z-0 hidden md:block">
    <img src="{{ asset('/storage/img/profile-page-bg-mobile-fix.png') }}" alt="profile" class="w-full absolute z-0 md:hidden">
    
    <div class="relative z-10 min-h-screen p-4 md:p-8">
        <!-- Back Button -->
        <div class="flex items-center w-fit gap-2 text-white cursor-pointer mb-5" id="profile-back-toggler">
            <iconify-icon icon="mingcute:left-fill" class="text-3xl md:text-5xl"></iconify-icon>
        </div>

        <form class="w-full flex flex-col items-center" method="POST" action="#" enctype="multipart/form-data">
            @csrf

            <!-- Profile Image -->
            <div class="w-40 h-40 md:w-64 md:h-64 rounded-full shadow-white-custom border-white border-4 mb-4 relative">
                <img src="{{ $imagePath }}" alt="Profile Image" id="gambar_profil" class="rounded-full w-full h-full object-cover">
                <input type="file" name="gambar_input" id="gambar_input" hidden>
                <button type="button" id="btn-upload" class="w-12 h-12 md:w-20 md:h-20 bg-pink-650 rounded-full absolute bottom-0 right-0 flex items-center justify-center text-white">
                    <iconify-icon icon="solar:camera-broken" class="text-2xl md:text-4xl"></iconify-icon>
                </button>
            </div>

            <input type="hidden" id="user_id_profile" value="{{ Auth::user()->id }}">
            <input type="hidden" id="user_role_profile" value="{{ Auth::user()->role_id }}">

            @php
                $dinas = match(true) {
                    Auth::user()->role->role == 'disperindag' => 'Dinas Perindustrian dan Perdagangan',
                    Auth::user()->role->role == 'dkpp' => 'Dinas Ketahanan Pangan dan Peternakan',
                    Auth::user()->role->role == 'dtphp' => 'Dinas Tanaman Pangan, Holtikultural, dan Perkebunan',
                    Auth::user()->role->role == 'perikanan' => 'Dinas Perikanan',
                    default => 'Admin'
                };
            @endphp

            <!-- Name & Role -->
            <div class="flex flex-col items-center gap-2 mb-8 text-center">
                <span class="text-2xl md:text-4xl font-semibold text-pink-650">{{ Auth::user()->name }}</span>
                <div class="text-black text-lg md:text-xl">{{ $dinas }}</div>
            </div>

            <!-- Nama -->
            <div class="w-full max-w-md mb-4 px-4">
                <label for="nama" class="flex items-center text-pink-650 text-lg md:text-xl font-semibold mb-2 gap-2">
                    <i class="bi bi-person-fill"></i> Nama
                </label>
                <div class="w-full bg-gray-90 rounded-full flex items-center gap-2">
                    <input type="text" class="flex-1 py-2 px-4 rounded-full outline-none text-gray-550" disabled value="{{ Auth::user()->name }}" id="nama" name="nama">
                    <iconify-icon icon="heroicons:pencil-square-solid" class="text-gray-550 text-xl cursor-pointer" id="btn_edit_nama"></iconify-icon>
                    <iconify-icon icon="ion:checkmark-done" class="text-gray-550 text-xl cursor-pointer hidden" id="btn_edit_nama_selesai"></iconify-icon>
                </div>
            </div>

            <!-- Username -->
            <div class="w-full max-w-md mb-4 px-4">
                <label for="username_profile" class="flex items-center text-pink-650 text-lg md:text-xl font-semibold mb-2 gap-2">
                    <i class="bi bi-person-fill"></i> Username
                </label>
                <div class="w-full bg-gray-90 rounded-full flex items-center gap-2">
                    <input type="text" class="flex-1 py-2 px-4 rounded-full outline-none text-gray-550" disabled value="{{ Auth::user()->username }}" id="username_profile" name="username_profile">
                    <iconify-icon icon="heroicons:pencil-square-solid" class="text-gray-550 text-xl cursor-pointer" id="btn_edit_username"></iconify-icon>
                    <iconify-icon icon="ion:checkmark-done" class="text-gray-550 text-xl cursor-pointer hidden" id="btn_edit_username_selesai"></iconify-icon>
                </div>
            </div>

            <!-- Email -->
            <div class="w-full max-w-md mb-6 px-4">
                <label for="email_profile" class="flex items-center text-pink-650 text-lg md:text-xl font-semibold mb-2 gap-2">
                    <i class="bi bi-envelope-fill"></i> Email
                </label>
                <input type="text" class="w-full py-2 px-4 rounded-full outline-none text-gray-550 bg-gray-90" disabled value="{{ Auth::user()->email }}" id="email_profile" name="email_profile">
            </div>

            <!-- Save Button -->
            <button type="button" id="profile_submit" class="w-10/12 max-w-xs mb-4 p-2 bg-green-500 rounded-full text-white flex justify-center items-center gap-2">
                <iconify-icon icon="material-symbols:save" class="text-xl"></iconify-icon>
                Simpan
            </button>
        </form>

        <!-- Logout -->
        <form class="w-full flex justify-center" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-10/12 max-w-xs p-2 mb-8 bg-red-500 rounded-full text-white flex justify-center items-center gap-2">
                <iconify-icon icon="material-symbols:logout" class="text-xl"></iconify-icon>
                Log Out
            </button>
        </form>
    </div>
</div>
<script>
    $(document).on('click', '#btn_edit_nama', function() {
        $(this).addClass('hidden');
        $('#btn_edit_nama_selesai').removeClass('hidden');

        $('#nama').removeAttr('disabled');
        $('#nama').addClass('border-2');
    });

    $(document).on('click', '#btn_edit_nama_selesai', function() {
        $(this).addClass('hidden');
        $('#btn_edit_nama').removeClass('hidden');

        $('#nama').attr('disabled', true);
        $('#nama').removeClass('border-2');
    });

    $(document).on('click', '#btn_edit_username', function() {
        $(this).addClass('hidden');
        $('#btn_edit_username_selesai').removeClass('hidden');

        $('#username_profile').removeAttr('disabled');
        $('#username_profile').addClass('border-2');
    });

    $(document).on('click', '#btn_edit_username_selesai', function() {
        $(this).addClass('hidden');
        $('#btn_edit_username').removeClass('hidden');

        $('#username_profile').attr('disabled', true);
        $('#username_profile').removeClass('border-2');
    });

    // Ajax update
    $(document).on('click', '#profile_submit', function() {
        const user_id = $('#user_id_profile').val();
        const formData = new FormData();

        formData.append('name', $('#nama').val());
        formData.append('username', $('#username_profile').val());
        formData.append('role_id', $('#user_role_profile').val());
        formData.append('email', $('#email_profile').val());

        const fileInput = $('#gambar_input')[0];
        if (fileInput.files.length > 0) {
            formData.append('user_image', fileInput.files[0]);
        }

        $.ajax({
            type: "POST",
            url: `/api/makundinas/${user_id}?_method=PUT`,
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: `Profile telah di update!.`,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let message = '';

                $.each(errors, function(key, value) {
                    message += value + '<br>';
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: message
                });
            }
        });
    });

    // Profile Image Clicker
    $(document).on('click', '#btn-upload', function() {
        $('#gambar_input').click();
    });

    $('#gambar_input').on('change', function() {
        let gambar = this;
        let text = $('#text-preview-gambar');
        let gambar_profil = $('#gambar_profil');

        const oFReader = new FileReader();
        oFReader.readAsDataURL(gambar.files[0]);

        oFReader.onload = function(oFREvent) {
            gambar_profil.attr('src', oFREvent.target.result);
        }
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
    
    $('#burger-menu').on('click', function() {
        $('#sidebar')
        .removeClass('hidden')
        .toggleClass('hidden')
        .slideToggle('slow');
    });
</script>