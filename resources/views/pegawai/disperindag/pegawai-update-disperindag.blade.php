<x-pegawai-layout>

        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('pegawai.disperindag.detail') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h3 class="text-lg font-semibold text-center max-md:text-base">Ubah Data</h3>
        </div>
    
        <div class="bg-bg-white p-6 rounded shadow-md mt-4">
            <form action="" method="POST">
                @csrf
                @method('PUT')
            
                <!-- Nama Pasar -->
                <div class="mb-4">
                    <label for="pasar" class="block text-pink-500 font-medium mb-1">Nama Pasar</label>
                    <input type="text" 
                           name="pasar"
                           id="pasar"
                           placeholder="Contoh: Pasar Tanjung" 
                           class="border p-2 w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400" 
                           value="{{ old('pasar', $data->pasar) }}">
                </div>
            
                <!-- Jenis Bahan Pokok -->
                <div class="mb-4">
                    <label for="jenis_bahan_pokok" class="block text-pink-500 font-medium mb-1">Jenis Bahan Pokok</label>
                    <input type="text" 
                           name="jenis_bahan_pokok"
                           id="jenis_bahan_pokok"
                           placeholder="Contoh: Daging" 
                           class="border p-2 w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400" 
                           value="{{ old('jenis_bahan_pokok', $data->jenis_bahan_pokok) }}">
                </div>
            
                <!-- Harga Barang -->
                <div class="mb-4">
                    <label for="kg_harga" class="block text-pink-500 font-medium mb-1">Harga Barang</label>
                    <input type="text" 
                           name="kg_harga"
                           id="kg_harga"
                           placeholder="Contoh: 100000,-" 
                           class="border p-2 w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400" 
                           value="{{ old('kg_harga', $data->kg_harga) }}">
                </div>
            
                <!-- Tanggal Dibuat -->
                <div class="mb-4">
                    <label for="tanggal_dibuat" class="block text-pink-500 font-medium mb-1">Tanggal Dibuat</label>
                    <input type="date" 
                           name="tanggal_dibuat"
                           id="tanggal_dibuat"
                           class="border border-gray-300 p-2 w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
                           value="{{ old('tanggal_dibuat', \Carbon\Carbon::parse($data->tanggal_dibuat)->format('Y-m-d')) }}">
                </div>
            </form>   
            <!-- Tombol -->
            <div class="flex justify-between mt-4">
                <button type="button" id="submitBtn" class="bg-yellow-550 text-white px-6 py-2 rounded-xl hover:bg-yellow-500">Simpan</button>
            </div>
        </div>
    </main>
</x-pegawai-layout>

<script>
    $('#submitBtn').on('click', function() {
        $.ajax({
            type: "PUT",
            url: "{{ route('api.dpp.update', $data->id) }}",
            data: {
                _token: "{{ csrf_token() }}",
                pasar: $('#pasar').val(),
                jenis_bahan_pokok: $('#jenis_bahan_pokok').val(),
                kg_harga: $('#kg_harga').val(),
                tanggal_dibuat: $('#tanggal_dibuat').val(),
                },
            success: function(data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: `Data ${data.data.jenis_bahan_pokok} berhasil diperbarui!`,
                    confirmButtonColor: '#16a34a'
                }).then(() => {
                    window.location.href = "{{ route('pegawai.disperindag.detail') }}";
                });    ;
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