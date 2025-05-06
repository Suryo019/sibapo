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
                    <label for="nama_bpokok" class="block text-pink-500">Nama Pasar</label>
                    <input type="text" name="nama_bpokok" placeholder="Contoh: Mangli" 
                           class="border p-2 w-full rounded-xl" id="nama_bpokok"
                           value="{{ old('nama_bpokok', $data->nama_bpokok) }}">
                </div>
    
                <!-- Gambar Bahan Pokok -->
                <div class="mb-4">
                    <label class="block text-pink-500 mb-2" for="gambar_bahan_pokok_input">Gambar Bahan Pokok</label>

                    <!-- Custom file upload button -->
                    <label for="gambar_bahan_pokok_input" 
                        class="inline-flex items-center px-4 py-2 bg-pink-500 text-white text-sm font-medium rounded-xl cursor-pointer hover:bg-pink-600 transition">
                        <i class="bi bi-upload me-2"></i> Pilih Gambar
                    </label>

                    <input type="file" name="gambar_bpokok" id="gambar_bahan_pokok_input" class="hidden" accept="image/*">

                    <!-- Preview -->
                    @if ($data->gambar_bpokok)
                        <div class="mt-4 flex flex-col ml-8">
                            <span class="text-slate-500 block" id="text-preview-gambar">Preview Gambar</span>
                            <img src="{{ asset('storage/' . $data->gambar_bpokok) }}" id="gambar_preview" alt="Preview Gambar" 
                                class="w-40 h-40 block rounded-xl object-contain border border-pink-200 p-1 shadow">
                        </div>
                    @else
                        <span class="text-gray-400 italic">Tidak ada gambar</span>
                    @endif
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
            url: "{{ route('api.addbpokok.update') }}",
            data: {
                _token: "{{ csrf_token() }}",
                nama_bpokok: $('#nama_bpokok').val(),
                },
            success: function(data) {     
                
                $('#nama_bpokok').val('');
                           
                Swal.fire({
                    title: 'Berhasil!',
                    text: `Data ${data.data.nama_bpokok} telah diperbarui.`,
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