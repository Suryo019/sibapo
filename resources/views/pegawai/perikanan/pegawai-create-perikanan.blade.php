<x-pegawai-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-green-50 p-6 rounded shadow-md mt-4">
            <form action="{{ route('api.dp.store') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Jenis Ikan</label>
                    <input type="text" placeholder="Contoh: Lele" 
                           class="border p-2 w-full rounded-full" id="jenis_ikan">
                </div>
    
                <div class="mb-4">
                    <label class="block text-gray-700">Volume Produksi (Ton)</label>
                    <input type="text" placeholder="Contoh: 100" 
                           class="border p-2 w-full rounded-full" id="ton_produksi">
                </div>
    
                <!-- Tombol -->
            </form>
        </div>

        <div class="flex justify-between mt-4">
            <a href="{{ route('pegawai.perikanan.detail') }}">
            <button type="button" class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Kembali</button>
            </a>
            <button type="button" id="submitBtn" class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Tambah</button>
        </div>
        
    </main>
</x-pegawai-layout>

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
                $('#jenis_ikan').val('');
                $('#ton_produksi').val('');

                Swal.fire({
                    title: 'Berhasil!',
                    text: `Data ${data.data.jenis_ikan} telah disimpan.`,
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