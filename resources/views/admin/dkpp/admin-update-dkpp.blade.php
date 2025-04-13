<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">Ubah Data</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <form method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700">Jenis Komoditas</label>
                    <input
                      type="text"
                      name="jenis_komoditas"
                      id="jenis_komoditas"
                      placeholder="Contoh: Daging"
                      class="border p-2 w-full rounded"
                      value="{{ old('jenis_komoditas', $data->jenis_komoditas) }}"
                    />
                  </div>
    
                <div class="mb-4">
                    <label class="block text-gray-700">Ketersediaan (Ton)</label>
                    <input
                    type="text"
                    name="ton_ketersediaan"
                    id="ton_ketersediaan"
                    placeholder="Contoh: 100"
                    class="border p-2 w-full rounded"
                    value="{{ old('ton_ketersediaan', $data->ton_ketersediaan) }}"
                  />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Kebutuhan Perminggu (Ton)</label>
                    <input
                    type="text"
                    name="ton_kebutuhan_perminggu"
                    id="ton_kebutuhan_perminggu"
                    placeholder="Contoh: 100"
                    class="border p-2 w-full rounded"
                    value="{{ old('ton_kebutuhan_perminggu', $data->ton_kebutuhan_perminggu) }}"
                  />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Neraca Mingguan (Ton)</label>
                    <input
                    type="text"
                    name="ton_neraca_mingguan"
                    id="ton_neraca_mingguan"
                    placeholder="Contoh: 100"
                    class="border p-2 w-full rounded"
                    value="{{ old('ton_neraca_mingguan', $data->ton_neraca_mingguan) }}"
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
                    <a href="{{ route('dkpp.detail') }}">
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
            url: "{{ route('api.dkpp.update', $data->id) }}",
            data: {
                _token: "{{ csrf_token() }}",
                jenis_komoditas: $('#jenis_komoditas').val(),
                ton_ketersediaan: $('#ton_ketersediaan').val(),
                ton_kebutuhan_perminggu: $('#ton_kebutuhan_perminggu').val(),
                ton_neraca_mingguan: $('#ton_neraca_mingguan').val(),
                tanggal_input: $('#tanggal_input').val(),
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