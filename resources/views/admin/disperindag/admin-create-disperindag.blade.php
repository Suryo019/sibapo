<x-admin-layout>

    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('disperindag.detail') }}" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h2 class="text-2xl font-semibold text-black-">{{ $title }}</h2>
        </div>

    
        <div class="bg-white p-6 rounded shadow-md mt-4 border bg-gray-10 border-gray-20">
            <form action="{{ route('api.dpp.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- Nama Pasar -->
                <div class="mb-4">
                    <label class="block text-pink-500">Nama Pasar</label>
                    <input type="text" placeholder="Contoh: Pasar Tanjung" 
                           class="border p-2 w-full rounded-xl" id="pasar">
                </div>
    
                <!-- Jenis Bahan Pokok -->
                <div class="mb-4">
                    <label class="block text-pink-500">Jenis Bahan Pokok</label>
                    <input type="text" placeholder="Contoh: Daging" 
                           class="border p-2 w-full rounded-xl" id="jenis_bahan_pokok">
                </div>

                <!-- Harga Barang -->
                <div class="mb-4">
                    <label class="block text-pink-500">Harga Barang</label>
                    <input type="text" placeholder="Contoh: 100000,-" 
                           class="border p-2 w-full rounded-xl" id="kg_harga">
                </div>
                
                <!-- Gambar Bahan Pokok -->
                <div class="mb-4">
                    <label class="block text-pink-500 mb-2" for="gambar_bahan_pokok_input">Gambar Bahan Pokok</label>

                    <!-- Custom file upload button -->
                    <label for="gambar_bahan_pokok_input" 
                        class="inline-flex items-center px-4 py-2 bg-pink-500 text-white text-sm font-medium rounded-xl cursor-pointer hover:bg-pink-600 transition">
                        <i class="bi bi-upload me-2"></i> Pilih Gambar
                    </label>

                    <input type="file" name="gambar_bahan_pokok" id="gambar_bahan_pokok_input" class="hidden" accept="image/*">

                    <!-- Preview -->
                    <div class="mt-4 flex flex-col ml-8">
                        <span class="text-slate-500 hidden" id="text-preview-gambar">Preview Gambar</span>
                        <img id="gambar_preview" alt="Preview Gambar" 
                            class="w-40 h-40 hidden rounded-xl object-contain border border-pink-200 p-1 shadow">
                    </div>
                </div>
    
            </form> 
        </div>
        
        <!-- Tombol -->
        <div class="flex justify-between mt-4">
            <button type="button" id="submitBtn" class="bg-yellow-550 text-white px-6 py-2 rounded-xl hover:bg-yellow-400">Simpan</button>
        </div>
        
    </main>
</x-admin-layout>

<script>
    // preview
    const input = document.getElementById('gambar_bahan_pokok_input');
    const preview = document.getElementById('gambar_preview');

    $('#gambar_bahan_pokok_input').on('change', function() {
        let gambar = this;
        let text = $('#text-preview-gambar');
        let gambar_preview = $('#gambar_preview');

        gambar_preview.toggleClass('hidden');
        gambar_preview.toggleClass('block');
        text.toggleClass('hidden');
        text.toggleClass('block');
        
        const oFReader = new FileReader();
        oFReader.readAsDataURL(gambar.files[0]);

        oFReader.onload = function(oFREvent) {
            gambar_preview.attr('src', oFREvent.target.result);
        }
    });

    // input.addEventListener('change', function () {
    //     const file = this.files[0];
    //     if (file) {
    //         preview.src = `storage/${URL.createObjectURL(file)}`;
    //         preview.classList.remove('hidden');
    //     } else {
    //         preview.classList.add('hidden');
    //     }
    // });

    $('#submitBtn').on('click', function() {
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('pasar', $('#pasar').val());
        formData.append('jenis_bahan_pokok', $('#jenis_bahan_pokok').val());
        formData.append('kg_harga', $('#kg_harga').val());

        let fileInput = $('#gambar_bahan_pokok_input')[0].files[0];
        if (fileInput !== undefined) {
            formData.append('gambar_bahan_pokok', fileInput);
        }

        $.ajax({
            type: "POST",
            url: "{{ route('api.dpp.store') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                $('#pasar').val('');
                $('#jenis_bahan_pokok').val('');
                $('#gambar_bahan_pokok_input').val('');
                $('#kg_harga').val('');

                $('#gambar_preview').attr('src', '').addClass('hidden');

                Swal.fire({
                    title: 'Berhasil!',
                    text: `Data ${data.data.jenis_bahan_pokok} telah disimpan.`,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: function(xhr) {
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