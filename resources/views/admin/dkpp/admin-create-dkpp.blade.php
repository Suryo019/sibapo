<x-admin-layout>
    <main class="flex-1 p-6">


        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
            <div class="w-full flex items-center gap-2 mb-4">
                <a href="{{ route('dkpp.detail') }}" class="text-decoration-none text-dark flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>                      
                </a>
                <h2 class="text-2xl font-semibold text-black">{{ $title }}</h2>
            </div>
    
        <div class="bg-white p-6 rounded shadow-md mt-4 border bg-gray-10 border-gray-20">
            <form method="POST" action="{{ route('api.dkpp.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-pink-500">Nama Komoditas</label>
                    <select id="jenis_komoditas_dkpp_id" name="jenis_komoditas_dkpp_id" class="border p-2 w-full rounded-xl bg-white text-black dark:text-black dark:bg-white">
                        <option value="" selected disabled>Pilih Komoditas</option>
                        @foreach ($commodities as $commodity)
                            <option value="{{ $commodity->id }}">
                                {{ $commodity->nama_komoditas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="ton_ketersediaan" class="block text-pink-500">Ketersediaan (Ton)</label>
                    <input 
                        type="text" 
                        name="ton_ketersediaan" 
                        id="ton_ketersediaan"
                        placeholder="Contoh: 100" 
                        class="border p-2 w-full rounded-xl">
                </div>

                <div class="mb-4">
                    <label for="ton_kebutuhan_perminggu" class="block text-pink-500">Kebutuhan Perminggu (Ton)</label>
                    <input 
                        type="text" 
                        name="ton_kebutuhan_perminggu" 
                        id="ton_kebutuhan_perminggu"
                        placeholder="Contoh: 100" 
                        class="border p-2 w-full rounded-xl">
                </div>

            </form>
        </div>
        
        <!-- Tombol -->
        <div class="flex justify-between mt-4">
            <button type="button" class="bg-yellow-550 text-white px-6 py-2 rounded-xl hover:bg-yellow-500" id="submitBtn">Simpan</button>
        </div>
        
    </main>
</x-admin-layout>

<script>
    $('#submitBtn').on('click', function() {
        $.ajax({
            type: "POST",
            url: "{{ route('api.dkpp.store') }}",
            data: {
                _token: "{{ csrf_token() }}",
                jenis_komoditas_dkpp_id: $('#jenis_komoditas_dkpp_id').val(),
                ton_ketersediaan: $('#ton_ketersediaan').val(),
                ton_kebutuhan_perminggu: $('#ton_kebutuhan_perminggu').val(),
                },
            success: function(data) {     
                
                $('#jenis_komoditas_dkpp_id').val('');
                $('#ton_ketersediaan').val('');
                $('#ton_kebutuhan_perminggu').val('');
                           
                Swal.fire({
                    title: 'Berhasil!',
                    text: `Data ${data.nama_komditas} telah disimpan.`,
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