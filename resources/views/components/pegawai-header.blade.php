@php
    $imagePath = optional(Auth::user())->user_image 
        ? asset('storage/' . Auth::user()->user_image) 
        : asset('storage/img/placeholder.png');
@endphp

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
        <img src="{{ $imagePath }}" alt="Profile"
             class="w-10 h-10 rounded-full bg-gray-300 scale-95 md:scale-100">
        <span class="text-sm hidden md:block">Hi, <b class="text-yellow-500">{{ Auth::user()->username }}</b>!</span>
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
                <img 
                src="{{ $imagePath }}" 
                alt="Profile Image" 
                id="gambar_profil" 
                class="rounded-full w-full h-full object-cover">

                <input type="file" name="gambar_input" id="gambar_input" hidden>

                <button type="button" id="btn-upload" class="w-20 h-20 bg-pink-650 rounded-full absolute bottom-0 right-0 flex items-center justify-center text-white">
                    <iconify-icon icon="solar:camera-broken" class="text-5xl"></iconify-icon>
                </button>
            </div>

            <input type="text" hidden id="user_id_profile" value="{{ Auth::user()->id }}">
            <input type="text" hidden id="user_role_profile" value="{{ Auth::user()->role_id }}">

            @php
                $dinas = match(true) {
                    Auth::user()->role->role == 'disperindag' => 'Dinas Perindustrian dan Perdagangan',
                    Auth::user()->role->role == 'dkpp' => 'Dinas Ketahanan Pangan dan Peternakan',
                    Auth::user()->role->role == 'dtphp' => 'Dinas Tanaman Pangan, Holtikultural, dan Perkebunan',
                    Auth::user()->role->role == 'perikanan' => 'Dinas Perikanan',
                    Auth::user()->role->role == 'pimpinan' => 'Pimpinan',
                    Auth::user()->role->role == 'admin' => 'Admin',
                };
            @endphp

            {{-- Name & role --}}
            <div class="flex flex-col items-center gap-3 mb-10">
                <div class="flex items-center gap-3">
                    <span class="text-4xl font-semibold text-pink-650">{{ Auth::user()->name }}</span>
                    {{-- <input type="text" id="nama" name="nama" value="{{ Auth::user()->name }}" class="w-11/12 py-2 px-4 rounded-full outline-gray-550 hidden border-gray-400 border-2 text-gray-550""> --}}
                    {{-- <iconify-icon icon="heroicons:pencil-square-solid" id="btn_edit_nama" class="text-gray-550 text-xl cursor-pointer"></iconify-icon> --}}
                </div>
                <div class="text-black text-xl w-full text-center">{{ $dinas }}</div>
            </div>

            {{-- Name, username & email --}}
            <div class="w-3/12 mb-4">
                <label for="nama" class="flex items-center text-pink-650 text-xl font-semibold mb-2 gap-2">
                    <i class="bi bi-person-fill"></i>
                    Nama
                </label>
                <div class="w-full bg-gray-90 rounded-full flex items-center gap-2">
                    <input type="text" class="w-11/12 py-2 px-4 rounded-full outline-none text-gray-550" disabled placeholder="Username" value="{{ Auth::user()->name }}" id="nama" name="nama">
                    <iconify-icon icon="heroicons:pencil-square-solid" class="w-1/12 text-gray-550 text-xl cursor-pointer" id="btn_edit_nama"></iconify-icon>
                    <iconify-icon icon="ion:checkmark-done" class="w-1/12 text-gray-550 text-xl cursor-pointer hidden" id="btn_edit_nama_selesai"></iconify-icon>
                </div>
            </div>

            <div class="w-3/12 mb-4">
                <label for="username_profile" class="flex items-center text-pink-650 text-xl font-semibold mb-2 gap-2">
                    <i class="bi bi-person-fill"></i>
                    Username
                </label>
                <div class="w-full bg-gray-90 rounded-full flex items-center gap-2">
                    <input type="text" class="w-11/12 py-2 px-4 rounded-full outline-none text-gray-550" disabled placeholder="Username" value="{{ Auth::user()->username }}" id="username_profile" name="username_profile">
                    <iconify-icon icon="heroicons:pencil-square-solid" class="w-1/12 text-gray-550 text-xl cursor-pointer" id="btn_edit_username"></iconify-icon>
                    <iconify-icon icon="ion:checkmark-done" class="w-1/12 text-gray-550 text-xl cursor-pointer hidden" id="btn_edit_username_selesai"></iconify-icon>
                </div>
            </div>

            <div class="w-3/12 mb-20">
                <label for="email_profile" class="flex items-center text-pink-650 text-xl font-semibold mb-2 gap-2">
                    <i class="bi bi-envelope-fill"></i>
                    Email
                </label>
                <input type="text" class="w-full py-2 px-4 rounded-full outline-none text-gray-550" disabled placeholder="Email" value="{{ Auth::user()->email }}" id="email_profile" name="email_profile">
            </div>

            <button type="button" id="profile_submit" class="w-2/12 mb-2 p-2 bg-green-500 rounded-full text-white flex justify-center items-center gap-4">
                <iconify-icon icon="material-symbols:save" class="w-1/12 text-white  text-xl"></iconify-icon>
                Simpan
            </button>
            
        </form>
        
        <form class="w-full h-full flex flex-col items-center" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-2/12 p-2 mb-8 bg-red-500 rounded-full text-white flex justify-center items-center gap-4">
                <iconify-icon icon="material-symbols:logout" class="w-1/12 text-white  text-xl"></iconify-icon>
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
    
    $('#burger-menu').on('click', function() {
    $('#sidebar')
        .removeClass('hidden')
        .toggleClass('hidden')
        .slideToggle('slow');
    });
</script>