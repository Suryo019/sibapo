<x-admin-layout>
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('disperindag.detail') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h2 class="text-2xl font-semibold text-black-">{{ $title }}</h2>
        </div>

    
        <div class="bg-white p-6 rounded shadow-md mt-4 border bg-gray-10 border-gray-20">
            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Nama Pasar -->
                <div class="mb-4">
                    <label for="nama_pasar" class="block text-pink-500">Nama Pasar</label>
                    <input type="text" name="nama_pasar" placeholder="Contoh: Mangli" 
                           class="border p-2 w-full rounded-xl" id="nama_pasar"
                           value="{{ old('nama_pasar', $data->nama_pasar) }}">
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
    $('#submitBtn').on('click', function() {
        $.ajax({
            type: "PUT",
            url: "{{ route('api.addpasar.update') }}",
            data: {
                _token: "{{ csrf_token() }}",
                nama_pasar: $('#nama_pasar').val(),
                },
            success: function(data) {     
                
                $('#nama_pasar').val('');
                           
                Swal.fire({
                    title: 'Berhasil!',
                    text: `Data ${data.data.nama_pasar} telah diperbarui.`,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                
            },
            error: function(xhr, status, error) {
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