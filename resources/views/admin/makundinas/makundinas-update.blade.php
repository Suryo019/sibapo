<x-admin-layout>
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('makundinas.index') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h3 class="text-lg font-semibold text-center max-md:text-base">Tambah Data</h3>
        </div>

        <div class="bg-white p-6 rounded shadow-md mt-4 border bg-gray-10 border-gray-20">
            <form action="{{ route('api.makundinas.store') }}" method="post" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                <input type="text" class="hidden" id="user_id" value="{{ $user->id }}">
                @csrf
                @method('PUT')
                <!-- Dinas -->
                <div class="mb-4">
                    <label class="block text-pink-500">Dinas</label>
                    <select name="role_id" class="border p-2 w-full rounded-xl" id="role_id">
                        <option value="" disabled>Pilih Dinas</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" 
                                {{ $role->id == $user->role_id ? 'selected' : '' }}>
                                {{ ucfirst($role->role) }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label for="name" class="block text-pink-500">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           placeholder="Contoh: Ahmad Selamet" 
                           class="border p-2 w-full rounded-xl" id="name">
                </div>
            
                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-pink-500">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" 
                           placeholder="Contoh: ahmadselamet99" 
                           class="border p-2 w-full rounded-xl" id="username">
                </div>
            
                <!-- Email/No Telp. -->
                <div class="mb-4">
                    <label for="email" class="block text-pink-500">Email</label>
                    <input type="text" name="email" value="{{ old('email', $user->email) }}" 
                           placeholder="Contoh: ahmadselamet99@mail.com" 
                           class="border p-2 w-full rounded-xl" id="email" required>
                </div>
    
            </form> 
        </div>
        
        <!-- Tombol -->
        <div class="flex justify-between mt-4">
            <button type="button" id="submitBtn" class="bg-yellow-550 text-white px-6 py-2 rounded-xl hover:bg-yellow-400">Simpan</button>
        </div>

    </main>
</x-admin-layout>

<script>
let user_id = $('#user_id').val()

const email = $('#email').val();


$('#submitBtn').on('click', function() {
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('role_id', $('#role_id').val());
    formData.append('name', $('#name').val());
    formData.append('username', $('#username').val());
    formData.append('email', $('#email').val());

    $.ajax({
        type: "POST",
        url: `/api/makundinas/${user_id}?_method=PUT`,
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            Swal.fire({
                title: 'Berhasil!',
                text: `Data user ${data.data.name} dari Dinas ${data.data.role} telah disimpan.`,
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

</script>
