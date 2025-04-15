<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
        <!-- Tombol Switch Produksi / Panen -->
        <div class="flex gap-4 mb-4">
            <a href="{{ route('dtphp.produksi') }}">
                <button class="text-green-700 rounded-t-md bg-white px-4 py-3 shadow-md relative top-24 left-4 {{ request()->routeIs('dtphp.detail.produksi') ? 'font-bold' : '' }}">
                    Volume Produksi
                </button>
            </a>
            <a href="{{ route('dtphp.panen') }}">
                <button class="text-gray-400 rounded-t-md bg-gray-100 px-4 py-3 relative top-[98px] shadow-md {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }}">
                    Luas Panen
                </button>
            </a>
        </div>
    
        <!-- Dropdown -->
        <div class="flex justify-between my-4">
            <div class="relative"> <!--tambahan ben opsi bisa dikanan-->
            </div>
            <div class="flex gap-4">

                <div>
                    <label for="pilih_komoditas" class="block text-sm font-medium text-gray-700 mb-1">Pilih Komoditas</label>
                    <select class="border p-2 rounded bg-white select2" id="pilih_komoditas">
                        {{-- <option value="" disabled selected>Pilih Komoditas</option> --}}
                        <option value="" selected>Suket Teki</option>
                        @foreach ($commodities as $commodity)
                            <option value="{{ $commodity }}">{{ $commodity }}</option>
                        @endforeach
                    </select>
                </div>

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
            </div>
        </div>
        

        <!-- Chart Placeholder -->
        <div class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8 relative z-10">
            <div class="flex items-center flex-col mb-3 font-bold text-green-910">
              <h3>Hektar Luas Panen April 2025</h3>
            </div>
            <div id="chart" class="w-full">
                {{-- Chartt --}}
            </div>
        </div>
    
        <!-- Button -->
        <div class="flex justify-center mt-4">
            <a href="{{ route('dtphp.detail.produksi') }}">
                <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">
                    Lihat Detail Data
                </button>
            </a>
        </div>
    </main>
</x-admin-layout>

<script>
    $.ajax({
        type: "GET",
        url: "{{ route('api.dtphp.produksi') }}",
        success: function(response) {
            let dataset = response.data;
            
            let jenis_komoditas = [];
            let produksi = [];

            $.each(dataset, function(key, value) {
                jenis_komoditas.push(value.jenis_komoditas);
                produksi.push(value.ton_volume_produksi);
            });

            console.log(jenis_komoditas);
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
                    categories: jenis_komoditas
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
        $('#pilih_jenis_komoditas').removeAttr('disabled');
    });

    // const data = fecth('http://sibapo.test/api/dpp').then(function(data) => console.log(data);
    
</script>