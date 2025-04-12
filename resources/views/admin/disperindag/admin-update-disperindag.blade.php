{{-- @dd($data) --}}

<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <form action="" method="POST">
                @csrf
                @method('PUT')
            
                <!-- Nama Pasar -->
                <div class="mb-4">
                    <label for="pasar" class="block text-gray-700 font-medium mb-1">Nama Pasar</label>
                    <input type="text" 
                           name="pasar"
                           id="pasar"
                           placeholder="Contoh: Pasar Tanjung" 
                           class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-400" 
                           value="{{ old('pasar', $data->pasar) }}">
                </div>
            
                <!-- Jenis Bahan Pokok -->
                <div class="mb-4">
                    <label for="jenis_bahan_pokok" class="block text-gray-700 font-medium mb-1">Jenis Bahan Pokok</label>
                    <input type="text" 
                           name="jenis_bahan_pokok"
                           id="jenis_bahan_pokok"
                           placeholder="Contoh: Daging" 
                           class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-400" 
                           value="{{ old('jenis_bahan_pokok', $data->jenis_bahan_pokok) }}">
                </div>
            
                <!-- Harga Barang -->
                <div class="mb-4">
                    <label for="kg_harga" class="block text-gray-700 font-medium mb-1">Harga Barang</label>
                    <input type="text" 
                           name="kg_harga"
                           id="kg_harga"
                           placeholder="Contoh: 100000,-" 
                           class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-400" 
                           value="{{ old('kg_harga', $data->kg_harga) }}">
                </div>
            
                <!-- Tanggal Dibuat -->
                <div class="mb-4">
                    <label for="tanggal_dibuat" class="block text-gray-700 font-medium mb-1">Tanggal Dibuat</label>
                    <input type="date" 
                           name="tanggal_dibuat"
                           id="tanggal_dibuat"
                           class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                           value="{{ old('tanggal_dibuat', \Carbon\Carbon::parse($data->tanggal_dibuat)->format('Y-m-d')) }}">
                </div>
            
                <!-- Tombol -->
                <div class="flex justify-between mt-4">
                    <a href="{{ route('disperindag.detail') }}">
                        <button type="button" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Kembali</button>
                    </a>
                    <button type="button" id="submitBtn" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Simpan</button>
                </div>
            </form>
            
        </div>
    </main>
</x-admin-layout>

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
                console.log(data);
                },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                }
        });
    });
</script>