<x-admin-layout>

    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <!-- Dropdown -->
        <div class="flex justify-between my-4">
            <div class="relative"> <!--tambahan ben opsi bisa dikanan-->
            </div>
            <div class="flex gap-4">
                {{-- Filter Pasar --}}
                <select class="border p-2 rounded bg-white select2" id="pilih_ikan">
                    {{-- <option value="" disabled selected>Pilih Ikan</option> --}}
                    <option value="" selected>Ikan Teri</option>
                    @foreach ($fishes as $fish)
                        <option value="{{ $fish }}">{{ $fish }}</option>
                    @endforeach
                </select>

                {{-- Filter Periode --}}
                <select class="border p-2 rounded bg-white select2" disabled id="pilih_periode">
                    {{-- <option value="" disabled selected>Pilih Periode</option> --}}
                    <option value="" disabled selected>April 2025</option>
                    @foreach ($periods as $period)
                        <option value="{{ $period }}">{{ $period }}</option>
                    @endforeach
                </select>

                {{-- Filter Bakpokting --}}
                <select class="border p-2 rounded bg-white select2" disabled id="pilih_jenis_ikan">
                    {{-- <option value="" disabled selected>Pilih Periode</option> --}}
                    <option value="" disabled selected>Teri</option>
                    @foreach ($data as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Chart Placeholder -->
        <div class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8">
            <div class="flex items-center flex-col mb-3 font-bold text-green-910">
              <h3>Volume Produksi Ikan Tahun 2025</h3>
            </div>
            <div id="chart" class="w-full">
                {{-- Chartt --}}
            </div>
        </div>
    
        <!-- Button -->
        <div class="flex justify-center mt-4">
            <a href="{{ route('perikanan.detail') }}">
                <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">
                    Lihat Detail Data
                </button>
            </a>
        </div>
    </main>

</x-admin-layout>

<script>
    $.ajax({
        type: "GET",
        url: "{{ route('api.dp.index') }}",
        success: function(response) {
            let dataset = response.data;
            
            let jenis_ikan = [];
            let produksi = [];

            $.each(dataset, function(key, value) {
                jenis_ikan.push(value.jenis_ikan);
                produksi.push(value.ton_produksi);
            });

            console.log(jenis_ikan);
            console.log(produksi);


            var options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                series: [{
                    name: 'Produksi',
                    data: produksi
                }],
                xaxis: {
                    categories: jenis_ikan
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });


    $('#pilih_ikan').on('change', function() {
        $('#pilih_periode').removeAttr('disabled');
    });

    $('#pilih_periode').on('change', function() {
        $('#pilih_ikan').removeAttr('disabled');
    });

    // const data = fecth('http://sibapo.test/api/dpp').then(function(data) => console.log(data);
    
</script>