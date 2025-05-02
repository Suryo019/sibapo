<x-manajemen-akun-dinas.makundinas-layout>
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('makundinas.detail') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h3 class="text-lg font-semibold text-center max-md:text-base">Tambah Data</h3>
        </div>

        <div class="bg-white p-6 rounded shadow-md mt-4 border bg-gray-10 border-gray-20">
            <form action="{{ route('api.makundinas.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- Dinas -->
                <div class="mb-4">
                    <label class="block text-pink-500">Dinas</label>
                    <select name="role_id" class="border p-2 w-full rounded-xl" id="dinas">
                        <option value="" disabled selected>Pilih Dinas</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->role) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label class="block text-pink-500">Nama Lengkap</label>
                    <input type="text" placeholder="Contoh: Ahmad Selamet" 
                           class="border p-2 w-full rounded-xl" id="nama">
                </div>
    
                <!-- Username -->
                <div class="mb-4">
                    <label class="block text-pink-500">Username</label>
                    <input type="text" placeholder="Contoh: ahmadselamet99" 
                           class="border p-2 w-full rounded-xl" id="username">
                </div>

                <!-- Email/No Telp. -->
                <div class="mb-4">
                    <label class="block text-pink-500">Email/ No Telp.</label>
                    <input type="text" name="email" placeholder="Contoh: ahmadselamet99@mail.com / 081234567890" 
                           class="border p-2 w-full rounded-xl" id="emailno" required>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-pink-500">Password</label>
                    <input type="password" name="password" placeholder="*********" 
                           class="border p-2 w-full rounded-xl" id="pass" required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="block text-pink-500">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="*********" 
                           class="border p-2 w-full rounded-xl" id="conpass" required>
                </div>
    
            </form> 
        </div>
        
        <!-- Tombol -->
        <div class="flex justify-between mt-4">
            <button type="button" id="submitBtn" class="bg-yellow-550 text-white px-6 py-2 rounded-xl hover:bg-yellow-400">Simpan</button>
        </div>

    </main>
</x-manajemen-akun-dinas.makundinas-layout>

<script>
$('#submitBtn').on('click', function() {
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('role_id', $('#dinas').val());
    formData.append('name', $('#nama').val());
    formData.append('username', $('#username').val());
    formData.append('email', $('#emailno').val());
    formData.append('password', $('#pass').val());
    formData.append('password_confirmation', $('#conpass').val());

    $.ajax({
        type: "POST",
        url: "{{ route('api.makundinas.store') }}",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            console.log(data);
            $('#dinas').val('');
            $('#nama').val('');
            $('#username').val('');
            $('#emailno').val('');
            $('#pass').val('');
            $('#conpass').val('');
            
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
