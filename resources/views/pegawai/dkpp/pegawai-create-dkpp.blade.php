<x-pegawai-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>

        <div class="bg-green-50 p-6 rounded shadow-md mt-4">
            <form method="POST" action="{{ route('api.dkpp.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="jenis_komoditas" class="block text-gray-700">Jenis Komoditas</label>
                    <input 
                        type="text" 
                        name="jenis_komoditas" 
                        id="jenis_komoditas"
                        placeholder="Contoh: Daging" 
                        class="border p-2 w-full rounded-full">
                </div>

                <div class="mb-4">
                    <label for="ton_ketersediaan" class="block text-gray-700">Ketersediaan (Ton)</label>
                    <input 
                        type="text" 
                        name="ton_ketersediaan" 
                        id="ton_ketersediaan"
                        placeholder="Contoh: 100" 
                        class="border p-2 w-full rounded-full">
                </div>

                <div class="mb-4">
                    <label for="ton_kebutuhan_perminggu" class="block text-gray-700">Kebutuhan Perminggu (Ton)</label>
                    <input 
                        type="text" 
                        name="ton_kebutuhan_perminggu" 
                        id="ton_kebutuhan_perminggu"
                        placeholder="Contoh: 100" 
                        class="border p-2 w-full rounded-full">
                </div>

                <!-- Tombol -->
            </form>
        </div>

        <div class="flex justify-between mt-4">
            <a href="{{ route('pegawai.dkpp.detail') }}">
                <button type="button" class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Kembali</button>
            </a>
            <button type="button" class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800" id="submitBtn">Tambah</button>
        </div>

    </main>
</x-pegawai-layout>

<script>
    $('#submitBtn').on('click', function() {
        $.ajax({
            type: "POST",
            url: "{{ route('api.dkpp.store') }}",
            data: {
                _token: "{{ csrf_token() }}",
                jenis_komoditas: $('#jenis_komoditas').val(),
                ton_ketersediaan: $('#ton_ketersediaan').val(),
                ton_kebutuhan_perminggu: $('#ton_kebutuhan_perminggu').val(),
                },
            success: function(data) {     
                
                $('#jenis_komoditas').val('');
                $('#ton_ketersediaan').val('');
                $('#ton_kebutuhan_perminggu').val('');
                           
                Swal.fire({
                    title: 'Berhasil!',
                    text: `Data ${data.data.jenis_komoditas} telah disimpan.`,
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