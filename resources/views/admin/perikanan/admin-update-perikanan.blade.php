<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <formmethod="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700">Jenis Ikan</label>
                    <input
                      type="text"
                      name="jenis_ikan"
                      id="jenis_ikan"
                      placeholder="Contoh: Lele"
                      class="border p-2 w-full rounded"
                      value="{{ old('jenis_ikan', $data->jenis_ikan) }}"
                    />
                </div>
    
                <div class="mb-4">
                    <label class="block text-gray-700">Volume Produksi (Ton)</label>
                    <input
                      type="text"
                      name="ton_produksi"
                      id="ton_produksi"
                      placeholder="Contoh: 100"
                      class="border p-2 w-full rounded"
                      value="{{ old('ton_produksi', $data->ton_produksi) }}"
                    />
                </div>
                
                <!-- Terakhir Diubah -->
                <div class="mb-4">
                    <label class="block text-gray-700">Terakhir Diubah</label>
                    <div class="relative">
                        <input
                        type="date"
                        name="tanggal_input"
                        id="tanggal_input"
                        class="border border-gray-300 p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ old('tanggal_input', \Carbon\Carbon::parse($data->tanggal_input)->format('Y-m-d')) }}"
                      />
                    </div>
                </div>       

                <!-- Tombol -->
                <div class="flex justify-between mt-4">
                    <a href="{{ route('perikanan.detail') }}">
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
            url: "{{ route('api.dp.update', $data->id) }}",
            data: {
                _token: "{{ csrf_token() }}",
                jenis_ikan: $('#jenis_ikan').val(),
                ton_produksi: $('#ton_produksi').val(),
                tanggal_input: $('#tanggal_input').val(),
                },
                success: function(data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: `Data ${data.data.jenis_ikan} berhasil diperbarui!`,
                    confirmButtonColor: '#16a34a'
                });

                window.location.href = "{{ route('perikanan.detail') }}";
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