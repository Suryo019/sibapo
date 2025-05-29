{{-- @dd($data) --}}

<x-pegawai-layout>
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        {{-- <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2> --}}
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('disperindag.detail') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h2 class="text-2xl font-semibold text-black-">{{ $title }}</h2>
        </div>
    
        <div class="bg-white p-6 rounded shadow-md mt-4 border bg-gray-10 border-gray-20">
            <form action="" method="POST" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                @csrf
                @method('PUT')
            
                <!-- Nama Pasar -->
                <div class="mb-4">
                    <label class="block text-pink-500">Nama Pasar</label>
                    <select id="pasar" name="pasar" class="border p-2 w-full rounded-xl bg-white text-black dark:text-black dark:bg-white">
                        <option value="" selected disabled>Pilih Pasar</option>
                        @foreach ($markets as $pasar)
                            <option value="{{ $pasar->id }}" {{ old('pasar', $data->pasar_id) == $pasar->id ? 'selected' : '' }}>
                                {{ $pasar->nama_pasar }}
                            </option>                        
                        @endforeach
                    </select>
                </div>

                {{-- Bahan Pokok --}}
                <div class="mb-4">
                    <label class="block text-pink-500">Jenis Bahan Pokok</label>
                    <select id="jenis_bahan_pokok" name="jenis_bahan_pokok" name="jenis_bahan_pokok" class="border p-2 w-full rounded-xl bg-white text-black">
                        <option value="" selected disabled>Pilih Bahan Pokok</option>
                        @foreach ($items as $bahan_pokok)
                            <option value="{{ $bahan_pokok->id }}" {{ old('jenis_bahan_pokok', $data->jenis_bahan_pokok_id) == $bahan_pokok->id ? 'selected' : '' }}>
                                {{ $bahan_pokok->nama_bahan_pokok }}
                            </option>
                        @endforeach
                    </select>
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
                           class="border border-gray-300 p-2 w-full rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                           value="{{ old('tanggal_dibuat', \Carbon\Carbon::parse($data->tanggal_dibuat)->format('Y-m-d')) }}">
                </div>
            </form>     
        </div>
        <!-- Tombol -->
        <div class="flex justify-between mt-4">
            <button type="button" id="submitBtn" class="bg-yellow-550 text-white px-6 py-2 rounded-xl hover:bg-yellow-500">Simpan</button>
        </div>

    </main>
</x-pegawai-layout>

<script>
    $('#submitBtn').on('click', function() {
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');
        formData.append('pasar', $('#pasar').val());
        formData.append('jenis_bahan_pokok', $('#jenis_bahan_pokok').val());
        formData.append('kg_harga', $('#kg_harga').val());
        formData.append('tanggal_dibuat', $('#tanggal_dibuat').val());

        $.ajax({
            type: "POST",
            url: "{{ route('api.dpp.update', $data->id) }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: `Data ${response.data.nama_bahan_pokok} berhasil diperbarui!`,
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