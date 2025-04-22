<x-pegawai-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>

        <!-- Form Card -->
        <div class="bg-green-50 p-6 rounded-xl shadow-md mt-6">
            <form method="POST">
                @csrf
                @method('PUT')

                <!-- Jenis Ikan -->
                <div class="mb-4">
                    <label for="jenis_ikan" class="block text-sm font-medium text-gray-700 mb-1">Jenis Ikan</label>
                    <input
                        type="text"
                        name="jenis_ikan"
                        id="jenis_ikan"
                        placeholder="Contoh: Lele"
                        class="w-full border border-gray-300 p-3 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500"
                        value="{{ old('jenis_ikan', $data->jenis_ikan) }}"
                    />
                </div>

                <!-- Volume Produksi -->
                <div class="mb-4">
                    <label for="ton_produksi" class="block text-sm font-medium text-gray-700 mb-1">Volume Produksi (Ton)</label>
                    <input
                        type="text"
                        name="ton_produksi"
                        id="ton_produksi"
                        placeholder="Contoh: 100"
                        class="w-full border border-gray-300 p-3 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500"
                        value="{{ old('ton_produksi', $data->ton_produksi) }}"
                    />
                </div>

                <!-- Tanggal Input -->
                <div class="mb-4">
                    <label for="tanggal_input" class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diubah</label>
                    <input
                        type="date"
                        name="tanggal_input"
                        id="tanggal_input"
                        class="w-full border border-gray-300 p-3 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500"
                        value="{{ old('tanggal_input', \Carbon\Carbon::parse($data->tanggal_input)->format('Y-m-d')) }}"
                    />
                </div>
            </form>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6">
            <a href="{{ route('pegawai.perikanan.detail') }}" class="w-full sm:w-auto">
                <button type="button" class="w-full bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800 transition duration-300">
                    Kembali
                </button>
            </a>
            <button type="button" id="submitBtn" class="w-full sm:w-auto bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800 transition duration-300">
                Simpan
            </button>
        </div>
    </main>
</x-pegawai-layout>

<script>
    $('#submitBtn').on('click', function () {
        $.ajax({
            type: "PUT",
            url: "{{ route('api.dp.update', $data->id) }}",
            data: {
                _token: "{{ csrf_token() }}",
                jenis_ikan: $('#jenis_ikan').val(),
                ton_produksi: $('#ton_produksi').val(),
                tanggal_input: $('#tanggal_input').val(),
            },
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: `Data ${data.data.jenis_ikan} berhasil diperbarui!`,
                    confirmButtonColor: '#16a34a'
                }).then(() => {
                    window.location.href = "{{ route('pegawai.perikanan.detail') }}";
                });
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let message = '';

                $.each(errors, function (key, value) {
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
