<x-pegawai-layout>
    <main class="flex-1 p-6 max-md:p-4">
        <h2 class="text-2xl font-semibold text-green-900 mb-4 max-md:mb-6 max-md:text-xl max-md:text-center">{{ $title }}</h2>
    
        <div class="bg-green-50 p-6 max-md:p-4 rounded shadow-md mt-4">
            <form action="" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Jenis Komoditas -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm max-md:text-xs mb-1">Jenis Komoditas</label>
                    <input
                      type="text"
                      name="jenis_komoditas"
                      id="jenis_komoditas"
                      placeholder="Contoh: Padi"
                      class="border border-gray-300 p-2 max-md:p-1.5 w-full rounded-full text-sm max-md:text-xs"
                      value="{{ old('jenis_komoditas', $data->jenis_komoditas) }}"
                    />
                </div>
                  
                <!-- Volume Produksi -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm max-md:text-xs mb-1">Volume Produksi (Ton)</label>
                    <input
                      type="text"
                      name="ton_volume_produksi"
                      id="ton_volume_produksi"
                      placeholder="Contoh: 100"
                      class="border border-gray-300 p-2 max-md:p-1.5 w-full rounded-full text-sm max-md:text-xs"
                      value="{{ old('ton_volume_produksi', $data->ton_volume_produksi) }}"
                    />
                </div>
                  
                <!-- Luas Panen -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm max-md:text-xs mb-1">Luas Panen (Hektar)</label>
                    <input
                      type="text"
                      name="hektar_luas_panen"
                      id="hektar_luas_panen"
                      placeholder="Contoh: 7"
                      class="border border-gray-300 p-2 max-md:p-1.5 w-full rounded-full text-sm max-md:text-xs"
                      value="{{ old('hektar_luas_panen', $data->hektar_luas_panen) }}"
                    />
                </div>
                  
                <!-- Tanggal Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm max-md:text-xs mb-1">Terakhir Diubah</label>
                    <div class="relative">
                      <input
                        type="date"
                        name="tanggal_input"
                        id="tanggal_input"
                        class="border border-gray-300 p-2 max-md:p-1.5 w-full rounded-full text-sm max-md:text-xs focus:outline-none focus:ring-2 focus:ring-green-400"
                        value="{{ old('tanggal_input', \Carbon\Carbon::parse($data->tanggal_input)->format('Y-m-d')) }}"
                      />
                    </div>
                </div>             

                <!-- Tombol -->
                <div class="flex justify-between mt-6 max-md:mt-4">
                    <a href="{{ route('pegawai.dtphp.detail.produksi') }}">
                        <button type="button" class="bg-green-700 text-white px-6 py-2 max-md:px-4 max-md:py-1.5 rounded-full hover:bg-green-800 text-sm max-md:text-xs">
                            Kembali
                        </button>
                    </a>
                    <button type="button" id="submitBtn" class="bg-green-700 text-white px-6 py-2 max-md:px-4 max-md:py-1.5 rounded-full hover:bg-green-800 text-sm max-md:text-xs">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </main>
</x-pegawai-layout>

<script>
    $(document).ready(function() {
        $('#submitBtn').on('click', function() {
            $.ajax({
                type: "PUT",
                url: "{{ route('api.dtphp.update', $data->id) }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    jenis_komoditas: $('#jenis_komoditas').val(),
                    ton_volume_produksi: $('#ton_volume_produksi').val(),
                    hektar_luas_panen: $('#hektar_luas_panen').val(),
                    tanggal_input: $('#tanggal_input').val(),
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: `Data ${data.data.jenis_komoditas} berhasil diperbarui!`,
                        confirmButtonColor: '#16a34a'
                    }).then(() => {
                        window.location.href = "{{ route('pegawai.dtphp.detail.produksi') }}";
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
                        html: message,
                        confirmButtonColor: '#16a34a'
                    });
                }
            });
        });
    });
</script>