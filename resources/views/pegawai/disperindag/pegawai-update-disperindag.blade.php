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

                <!-- Gambar Bahan Pokok -->
                <div class="mb-4">
                    <label class="block text-pink-500 mb-2" for="gambar_bahan_pokok_input">Gambar Bahan Pokok</label>

                    <!-- Custom file upload button -->
                    <label for="gambar_bahan_pokok_input" 
                        class="inline-flex items-center px-4 py-2 bg-pink-500 text-white text-sm font-medium rounded-xl cursor-pointer hover:bg-pink-600 transition">
                        <i class="bi bi-upload me-2"></i> Pilih Gambar
                    </label>

                    <input type="file" name="gambar_bahan_pokok" id="gambar_bahan_pokok_input" class="hidden" accept="image/*">

                    <!-- Preview -->
                    @if ($data->gambar_bahan_pokok)
                        <div class="mt-4 flex flex-col ml-8">
                            <span class="text-slate-500 block" id="text-preview-gambar">Preview Gambar</span>
                            <img src="{{ asset('storage/' . $data->gambar_bahan_pokok) }}" id="gambar_preview" alt="Preview Gambar" 
                                class="w-40 h-40 block rounded-xl object-contain border border-pink-200 p-1 shadow">
                        </div>
                    @else
                        <span class="text-gray-400 italic">Tidak ada gambar</span>
                    @endif

            </form>   
        </div>
        <!-- Tombol -->
        <div class="flex justify-between mt-4">
            <button type="button" id="submitBtn" class="bg-yellow-550 text-white px-6 py-2 rounded-xl hover:bg-yellow-500">Simpan</button>
        </div>
    </main>
</x-pegawai-layout>

<script>
    // preview
    $('#gambar_bahan_pokok_input').on('change', function() {
        let gambar = this;
        let text = $('#text-preview-gambar');
        let gambar_preview = $('#gambar_preview');
        
        const oFReader = new FileReader();
        oFReader.readAsDataURL(gambar.files[0]);

        oFReader.onload = function(oFREvent) {
            gambar_preview.attr('src', oFREvent.target.result);
        }
    });

    $('#submitBtn').on('click', function() {
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');
        formData.append('pasar', $('#pasar').val());
        formData.append('jenis_bahan_pokok', $('#jenis_bahan_pokok').val());
        formData.append('kg_harga', $('#kg_harga').val());
        formData.append('tanggal_dibuat', $('#tanggal_dibuat').val());
        
        let fileInput = $('#gambar_bahan_pokok_input')[0].files[0];
        if (fileInput !== undefined) {
            formData.append('gambar_bahan_pokok', fileInput);
        }

        $.ajax({
            type: "POST",
            url: "{{ route('api.dpp.update', $data->id) }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: `Data ${data.data.jenis_bahan_pokok} berhasil diperbarui!`,
                    confirmButtonColor: '#16a34a'
                }).then(() => {
                    window.location.href = "{{ route('pegawai.disperindag.detail') }}";
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