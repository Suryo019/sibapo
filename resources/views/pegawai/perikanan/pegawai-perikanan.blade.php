<x-pegawai-layout>

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 my-4">
        <!-- Search Component -->
        <div class="w-full md:w-auto">
            <x-search />
        </div>
    
        <!-- Filter -->
        <div class="w-full md:w-auto flex justify-end">
            <div class="relative flex justify-end w-full md:w-auto">
                <x-filter />
    
                <!-- Modal Background -->
                <x-filter-modal>
                    <form action="" method="get">
                        <div class="space-y-4">
                            <!-- Pilih Periode -->
                            <div class="flex flex-col">
                                <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                                    Pilih Periode
                                </label>
                                <select id="pilih_periode"
                                    class="w-full rounded border border-gray-300 p-2 bg-white text-sm max-md:text-xs focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                    <option value="" disabled selected>Pilih Periode</option>
                                    @foreach ($periods as $period)
                                        <option value="{{ $period }}">{{ $period }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Pilih Minggu -->
                            <div class="flex flex-col">
                                <label for="pilih_minggu" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                                    Minggu ke
                                </label>
                                <select id="pilih_minggu"
                                    class="w-full rounded border border-gray-300 p-2 bg-white text-sm max-md:text-xs focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" disabled>
                                    <option value="" disabled selected>Pilih Minggu</option>
                                    <option value="1">Minggu 1</option>
                                    <option value="2">Minggu 2</option>
                                    <option value="3">Minggu 3</option>
                                    <option value="4">Minggu 4</option>
                                </select>
                            </div>
                        </div>

                        <div class="w-full flex justify-end gap-3 mt-10">
                            <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-1">
                                Reset
                            </button>
                            <button type="submit" class="bg-pink-650 text-white rounded-lg w-20 p-1">
                                Cari
                            </button>
                        </div>
                    </form>
                </x-filter-modal> 
            </div>
        </div>
    </div>
    
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('perikanan.index') }}" class="flex-shrink-0 text-dark">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
            <h3 class="text-xl font-extrabold text-center max-md:text-base">
                Volume Produksi
            </h3>
        </div>
    
        <!-- Chart Section -->
        <div class="w-full bg-white rounded-2xl shadow-md p-8 flex flex-col items-center justify-center border bg-gray-10 border-gray-20">
            <h3 class="text-lg font-bold text-black mb-4 text-center">
                Volume Produksi Ikan Tahun 2025
            </h3>
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

    // Trigger Filter Modal
    function toggleModal() {
        const modal = document.getElementById('filterModal');
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }

    $("#filterBtn").on("click", function() {
        $("#filterModal").toggleClass("hidden");
    });
    // End Trigger Filter Modal
</script>
