<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <form action="{{ route('api.dpp.store') }}" method="post">
                @csrf
                <!-- Nama Pasar -->
                <div class="mb-4">
                    <label class="block text-gray-700">Nama Pasar</label>
                    <input type="text" placeholder="Contoh: Pasar Tanjung" 
                           class="border p-2 w-full rounded" id="pasar">
                </div>
    
                <!-- Jenis Bahan Pokok -->
                <div class="mb-4">
                    <label class="block text-gray-700">Jenis Bahan Pokok</label>
                    <input type="text" placeholder="Contoh: Daging" 
                           class="border p-2 w-full rounded" id="jenis_bahan_pokok">
                </div>
    
                <!-- Harga Barang -->
                <div class="mb-4">
                    <label class="block text-gray-700">Harga Barang</label>
                    <input type="text" placeholder="Contoh: 100000,-" 
                           class="border p-2 w-full rounded" id="kg_harga">
                </div>
    
                <!-- Tombol -->
            </form> 
        </div>

        <div class="flex justify-between mt-4">
            <a href="{{ route('disperindag.index') }}">
            <button type="button" class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Kembali</button>
            </a>
            <button type="button" id="submitBtn" class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">Tambah</button>
        </div>
        
    </main>
</x-admin-layout>

<script>
    $('#submitBtn').on('click', function() {
        $.ajax({
            type: "POST",
            url: "{{ route('api.dpp.store') }}",
            data: {
                _token: "{{ csrf_token() }}",
                pasar: $('#pasar').val(),
                jenis_bahan_pokok: $('#jenis_bahan_pokok').val(),
                kg_harga: $('#kg_harga').val(),
                },
            success: function(data) {   
                $('#pasar').val('');
                $('#jenis_bahan_pokok').val('');
                $('#kg_harga').val('');

                Swal.fire({
                    title: 'Berhasil!',
                    text: `Data ${data.data.jenis_bahan_pokok} telah disimpan.`,
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