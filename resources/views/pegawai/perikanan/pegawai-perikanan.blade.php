<x-pegawai-layout>
    <main class="flex-1 p-6">
        {{-- <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2> --}}

            <div class="flex justify-between items-center gap-4 my-4 max-md:flex-wrap">
                <!-- Search Component -->
                <x-search></x-search>
            
                <!-- Filter Component -->
                <x-filter></x-filter>
            </div>


            {{-- <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto"> --}}
                {{-- Filter Ikan --}}
                {{-- <div class="w-full md:w-auto">
                    <label for="pilih_ikan" class="block text-sm font-medium text-gray-700 mb-1">Pilih Ikan</label>
                    <select id="pilih_ikan" class="w-full border border-black p-2 rounded-full bg-white select2">
                        <option value="" selected>Ikan Teri</option>
                        @foreach ($fishes as $fish)
                            <option value="{{ $fish }}">{{ $fish }}</option>
                        @endforeach
                    </select>
                </div> --}}
                {{-- Filter Periode --}}
                {{-- <div class="w-full md:w-auto">
                    <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                    <select id="pilih_periode" class="w-full border border-black p-2 rounded-full bg-white select2" disabled>
                        <option value="" disabled selected>April 2025</option>
                        @foreach ($periods as $period)
                            <option value="{{ $period }}">{{ $period }}</option>
                        @endforeach
                    </select>
                </div> --}}
                {{-- Filter Jenis Ikan --}}
                {{-- <div class="w-full md:w-auto">
                    <label for="pilih_jenis_ikan" class="block text-sm font-medium text-gray-700 mb-1">Pilih Jenis Ikan</label>
                    <select id="pilih_jenis_ikan" class="w-full md:w-24 border border-black p-2 rounded-full bg-white select2" disabled>
                        <option value="" disabled selected>Teri</option>
                        @foreach ($data as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div> --}}


        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
            <div class="w-full flex items-center gap-2 mb-4">
                <a href="{{ route('perikanan.index') }}" class="text-decoration-none text-dark flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>                      
                </a>
                <h3 class="text-xl font-extrabold text-center max-md:text-base"> Volume Produksi </h3>
            </div>

        
        <!-- Chart Section -->
        <div class="w-full bg-white rounded-2xl shadow-md p-8 flex flex-col items-center justify-center border bg-gray-10 border-gray-20">
            <h3 class="text-lg font-bold text-green-900 mb-4">Volume Produksi Ikan Tahun 2025</h3>
            <div id="chart" class="w-full">
                {{-- Chart will render here --}}
            </div>
        </div>

        <!-- Button -->
        <div class="flex justify-start mt-6">
            <a href="{{ route('pegawai.perikanan.detail') }}">
                <button class="bg-yellow-550 text-md text-white px-3 py-2 rounded-lg hover:bg-yellow-500 max-md:text-xs max-md:px-4 max-md:py-1">
                    Lihat Detail Data
                </button>
            </a>
        </div>
    </main>
</x-pegawai-layout>

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
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });

    $('#pilih_ikan').on('change', function() {
        $('#pilih_periode').removeAttr('disabled');
    });

    $('#pilih_periode').on('change', function() {
        $('#pilih_ikan').removeAttr('disabled');
    });
</script>
