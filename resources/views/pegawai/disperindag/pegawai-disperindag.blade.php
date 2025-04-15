<x-pegawai-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <!-- Dropdown -->
        <div class="flex justify-between my-4">
            <div class="relative"> <!--tambahan ben opsi bisa dikanan-->
            </div>
            <div class="flex gap-4">
                {{-- Filter Pasar --}}
                <div>
                    <label for="pilih_pasar" class="block text-sm font-medium text-gray-700 mb-1">Pilih Pasar</label>
                    <select class="border p-2 rounded bg-white select2" id="pilih_pasar">
                        {{-- <option value="" disabled selected>Pilih Pasar</option> --}}
                        <option value="" selected>Pasar Tanjung</option>
                        @foreach ($markets as $market)
                            <option value="{{ $market }}">{{ $market }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Periode --}}
                <div>
                    <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                    <select class="border p-2 rounded bg-white select2" disabled id="pilih_periode">
                        {{-- <option value="" disabled selected>Pilih Periode</option> --}}
                        <option value="" disabled selected>April 2025</option>
                        @foreach ($periods as $period)
                            <option value="{{ $period }}">{{ $period }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Bakpokting --}}
                <div>
                    <label for="pilih_bahan_pokok" class="block text-sm font-medium text-gray-700 mb-1">Pilih Bahan Pokok</label>
                    <select class="border p-2 rounded bg-white select2" disabled id="pilih_bahan_pokok">
                        {{-- <option value="" disabled selected>Pilih Periode</option> --}}
                        <option value="" disabled selected>Daging</option>
                        @foreach ($data as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Chart Placeholder -->
        <div class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8">
            <div class="flex items-center flex-col mb-3 font-bold text-green-910">
              <h3>Data Harga Bahan Pokok Pasar Tanjung April 2025</h3>
            </div>
            <div id="chart" class="w-full">
                {{-- Chartt --}}
            </div>
        </div>
    
        <!-- Button -->
        <div class="flex justify-center mt-4">
            <a href="{{ route('pegawai.disperindag.detail') }}">
                <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">
                    Lihat Detail Data
                </button>
            </a>
        </div>
    </main>
</x-pegawai-layout>

<script>
    $.ajax({
        type: "GET",
        url: "{{ route('api.dpp.index') }}",
        success: function(response) {
            let dataset = response.data;
            
            let jenis_bahan_pokok = [];
            let harga = [];

            $.each(dataset, function(key, value) {
                jenis_bahan_pokok.push(value.jenis_bahan_pokok);
                harga.push(value.kg_harga);
            });

            console.log(jenis_bahan_pokok);
            console.log(harga);


            var options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                series: [{
                    name: 'Harga',
                    data: harga
                }],
                xaxis: {
                    categories: jenis_bahan_pokok
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });


    $('#pilih_pasar').on('change', function() {
        $('#pilih_periode').removeAttr('disabled');
    });

    $('#pilih_periode').on('change', function() {
        $('#pilih_bahan_pokok').removeAttr('disabled');
    });

    // const data = fecth('http://sibapo.test/api/dpp').then(function(data) => console.log(data);
    
</script>