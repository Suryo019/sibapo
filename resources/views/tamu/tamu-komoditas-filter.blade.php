<x-tamu-layout>
    <div class="w-full h-[500px] flex flex-col justify-center items-center text-pink-650 ">
        <h1 class="text-5xl font-extrabold mb-10">Harga Komoditas</h1>
        <h5 class="text-xl text-shadow mb-7">Harga rata-rata dibandingkan dengan hari sebelumnya <b>{{ $kemarin }}</b></h5>
        <form action="">
            @csrf
            <div class="w-96 bg-yellow-450 flex justify-between items-center pl-6 pr-3 py-1 rounded-full">
                <span class="bi bi-search mr-5"></span>
                <input type="text" placeholder="Cari Pasar" id="komoditas_search" name="komoditas_search" class="border-none outline-none placeholder-pink-650 bg-transparent flex-1">
                <button class="bg-pink-650 rounded-full py-2 w-24 text-white" id="submitBtn">Cari</button>
            </div>
        </form>
    </div>

    {{-- Daftar Komoditas --}}
    {{-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 justify-items-center">
        @foreach ($data as $item)
        <div class="bg-white rounded-3xl shadow-md overflow-hidden border h-72 w-72 py-3 px-1">
            <div class="h-[50%] flex justify-center">
                <img src="{{ asset('storage/img/ayam.png') }}" alt="komoditas" class="object-cover">
            </div>
            <div class="p-4 h-[50%]">
                <p class="text-gray-600">{{ $item['komoditas'] }}</p>
                <h3 class="text-2xl font-extrabold mb-4">Rp. {{ $item['rata_rata_hari_ini'] }}/kg</h3>
                @if ($item['status'] == 'Stabil')
                    <span class="flex justify-center items-center bg-blue-200 w-full rounded-full p-2 text-blue-600 font-extrabold gap-3">
                        <i class="bi bi-circle font-extrabold"></i>
                        {{ $item['status'] }} Rp. {{ $item['selisih'] }}
                    </span>
                @elseif ($item['status'] == 'Naik')
                    <span class="flex justify-center items-center bg-green-200 w-full rounded-full p-2 text-green-600 font-extrabold gap-3">
                        <i class="bi bi-arrow-up font-extrabold"></i>
                        {{ $item['status'] }} Rp. {{ $item['selisih'] }}
                    </span>
                @elseif ($item['status'] == 'Turun')
                    <span class="flex justify-center items-center bg-red-200 w-full rounded-full p-2 text-red-600 font-extrabold gap-3">
                        <i class="bi bi-arrow-down font-extrabold"></i>
                        {{ $item['status'] }} Rp. {{ $item['selisih'] }}
                    </span>
                @else
                    <span class="flex justify-center items-center bg-slate-200 w-full rounded-full p-2 text-slate-600 font-extrabold gap-3">
                        {{ $item['status'] }}
                    </span>
                @endif
            </div>
        </div>
        @endforeach
    </div> --}}
</x-tamu-layout>

{{-- BELOM SELESAI --}}
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