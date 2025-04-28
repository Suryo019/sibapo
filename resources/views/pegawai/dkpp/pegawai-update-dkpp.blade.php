<x-pegawai-layout>

        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('pegawai.dkpp.detail') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h3 class="text-lg font-semibold text-center max-md:text-base">Ubah Data</h3>
        </div>

        <div class="bg-white p-6 rounded shadow-md mt-4">
            <form action="{{ route('dkpp.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Jenis Komoditas -->
                <div class="mb-4">
                    <label for="jenis_komoditas" class="block text-pink-500">Jenis Komoditas</label>
                    <input type="text" name="jenis_komoditas" id="jenis_komoditas"
                           value="{{ old('jenis_komoditas', $data->jenis_komoditas) }}" 
                           class="border p-2 w-full rounded-xl" placeholder="Contoh: Daging">
                </div>

                <!-- Ketersediaan -->
                <div class="mb-4">
                    <label for="ton_ketersediaan" class="block text-pink-500">Ketersediaan (Ton)</label>
                    <input type="number" name="ton_ketersediaan" id="ton_ketersediaan"
                           value="{{ old('ton_ketersediaan', $data->ton_ketersediaan) }}" 
                           class="border p-2 w-full rounded-xl" placeholder="Contoh: 100">
                </div>

                <!-- Kebutuhan -->
                <div class="mb-4">
                    <label for="ton_kebutuhan_perminggu" class="block text-pink-500">Kebutuhan Perminggu (Ton)</label>
                    <input type="number" name="ton_kebutuhan_perminggu" id="ton_kebutuhan_perminggu"
                           value="{{ old('ton_kebutuhan_perminggu', $data->ton_kebutuhan_perminggu) }}" 
                           class="border p-2 w-full rounded-xl" placeholder="Contoh: 100">
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