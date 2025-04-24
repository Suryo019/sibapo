<x-pegawai-layout>
    <main class="flex-1 p-6 max-md:p-4">
        <h2 class="text-2xl font-semibold text-green-900 mb-4 max-md:mb-10 max-md:text-xl max-md:text-center">{{ $title }}</h2>

        <!-- Tombol Switch Produksi / Panen -->
        <div class="flex gap-4 mb-4">
            <a href="{{ route('pegawai.dtphp.produksi') }}">
                <button class="text-gray-400 rounded-t-md bg-gray-100 px-4 py-3 relative top-24 shadow-md left-4 text-sm {{ request()->routeIs('dtphp.detail.produksi') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2 max-md:left-2">
                    Volume Produksi
                </button>
            </a>
            <a href="{{ route('pegawai.dtphp.panen') }}">
                <button class="text-green-700 rounded-t-md bg-white px-4 py-3 shadow-md relative top-24 text-sm {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2 ">
                    Luas Panen
                </button>
            </a>
        </div>
    
        <!-- Dropdown -->
        <div class="flex justify-end my-4">
            <div class="flex flex-wrap gap-6 max-md:gap-4 items-end justify-end w-full">
                <!-- Pilih Komoditas -->
                <div class="flex flex-col">
                    <label for="pilih_komoditas" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                        Pilih Komoditas
                    </label>
                    <select id="pilih_komoditas"
                        class="select2 w-36 max-md:w-28 rounded-full border border-gray-300 p-2 bg-white text-sm max-md:text-xs">
                        <option value="" selected>Suket Teki</option>
                        @foreach ($commodities as $commodity)
                            <option value="{{ $commodity }}">{{ $commodity }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Periode -->
                <div class="flex flex-col">
                    <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                        Pilih Periode
                    </label>
                    <select id="pilih_periode"
                        class="select2 w-36 max-md:w-28 rounded-full border border-gray-300 p-2 bg-white text-sm max-md:text-xs" disabled>
                        <option value="" disabled selected>April 2025</option>
                        @foreach ($periods as $period)
                            <option value="{{ $period }}">{{ $period }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Chart Container-->
        <div class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8 max-md:p-4 relative z-10">
            <div class="flex items-center flex-col mb-3 font-bold text-green-910 text-center max-md:text-[12px]">
                <h3>Hektar Luas Panen April 2025</h3>
            </div>

            <div id="chart" class="w-full">
                {{-- Chart --}}
            </div>
        </div>
    
        <!-- Button-->
        <div class="flex justify-center mt-6">
            <a href="{{ route('pegawai.dtphp.detail.panen') }}">
                <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800 text-sm max-md:text-xs max-md:px-4 max-md:py-1">
                    Lihat Detail Data
                </button>
            </a>
        </div>
    </main>
</x-pegawai-layout>

<script>
    $.ajax({
        type: "GET",
        url: "{{ route('api.dtphp.panen') }}",
        success: function(response) {
            let dataset = response.data;
            
            let jenis_komoditas = [];
            let panen = [];

            $.each(dataset, function(key, value) {
                jenis_komoditas.push(value.jenis_komoditas);
                panen.push(value.hektar_luas_panen);
            });

            var options = {
                chart: {
                    type: 'line',
                    height: 350,
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                series: [{
                    name: 'Panen',
                    data: panen
                }],
                xaxis: {
                    categories: jenis_komoditas,
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Hektar'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + ' hektar';
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

    $('#pilih_komoditas').on('change', function() {
        $('#pilih_periode').prop('disabled', false);
    });
</script>