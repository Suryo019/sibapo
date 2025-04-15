<x-pegawai-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">Ubah Data</h2>

        <div class="bg-white p-6 rounded shadow-md mt-4">
            <form action="{{ route('dkpp.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Jenis Komoditas -->
                <div class="mb-4">
                    <label for="jenis_komoditas" class="block text-gray-700">Jenis Komoditas</label>
                    <input type="text" name="jenis_komoditas" id="jenis_komoditas"
                           value="{{ old('jenis_komoditas', $data->jenis_komoditas) }}" 
                           class="border p-2 w-full rounded" placeholder="Contoh: Daging">
                </div>

                <!-- Ketersediaan -->
                <div class="mb-4">
                    <label for="ton_ketersediaan" class="block text-gray-700">Ketersediaan (Ton)</label>
                    <input type="number" name="ton_ketersediaan" id="ton_ketersediaan"
                           value="{{ old('ton_ketersediaan', $data->ton_ketersediaan) }}" 
                           class="border p-2 w-full rounded" placeholder="Contoh: 100">
                </div>

                <!-- Kebutuhan -->
                <div class="mb-4">
                    <label for="ton_kebutuhan_perminggu" class="block text-gray-700">Kebutuhan Perminggu (Ton)</label>
                    <input type="number" name="ton_kebutuhan_perminggu" id="ton_kebutuhan_perminggu"
                           value="{{ old('ton_kebutuhan_perminggu', $data->ton_kebutuhan_perminggu) }}" 
                           class="border p-2 w-full rounded" placeholder="Contoh: 100">
                </div>

                <!-- Tombol -->
                <div class="flex justify-between mt-4">
                    <a href="{{ route('pegawai.dkpp.detail') }}">
                        <button type="button" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Kembali</button>
                    </a>
                    <button type="button" id="submitBtn" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Ubah</button>
                </div>
            </form>
        </div>
    </main>
</x-pegawai-layout>

<script>
    $('#submitBtn').on('click', function() {
        $.ajax({
            type: "PUT",
            url: "{{ route('api.dkpp.update', $data->id) }}",
            data: {
                _token: "{{ csrf_token() }}",
                jenis_komoditas: $('#jenis_komoditas').val(),
                ton_ketersediaan: $('#ton_ketersediaan').val(),
                ton_kebutuhan_perminggu: $('#ton_kebutuhan_perminggu').val(),
                },
            success: function(data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: `Data ${data.data.jenis_komoditas} berhasil diperbarui!`,
                    confirmButtonColor: '#16a34a'
                });

                window.location.href = "{{ route('pegawai.dkpp.detail') }}";
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