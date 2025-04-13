<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <form>
                <div class="mb-4">
                    <label class="block text-gray-700">Jenis Ikan</label>
                    <input type="text" placeholder="Contoh: Lele" 
                           class="border p-2 w-full rounded" id="jenis_ikan">
                </div>
    
                <div class="mb-4">
                    <label class="block text-gray-700">Volume Produksi (Ton)</label>
                    <input type="text" placeholder="Contoh: 100" 
                           class="border p-2 w-full rounded" id="ton_produksi">
                </div>
    
                <!-- Tombol -->
                <div class="flex justify-between mt-4">
                    <a href="{{ route('perikanan.detail') }}">
                    <button type="button" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Kembali</button>
                    </a>
                    <button type="submit" id="submitBtn" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Tambah</button>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>

<script>
    $('#submitBtn').on('click', function() {
        $.ajax({
            type: "POST",
            url: "{{ route('api.dp.store') }}",
            data: {
                _token: "{{ csrf_token() }}",
                jenis_ikan: $('#jenis_ikan').val(),
                ton_produksi: $('#ton_produksi').val(),
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