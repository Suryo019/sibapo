<x-admin-layout>
    
        <!-- Dropdown Section -->
<div class="flex flex-col my-4 w-full gap-4">
    <div class="flex items-center justify-between flex-wrap gap-6 max-md:gap-4">

        <!-- Search Component -->
        <x-search class="w-full sm:w-auto" />
                
        <!-- Filter Component -->
        <div class="flex justify-end w-full sm:w-auto">
            <div class="relative flex justify-end">
                <x-filter />

                <!-- Modal Background -->
                <div id="filterModal" class="mt-10 absolute hidden items-center justify-center z-50 w-full">
                    <!-- Modal Content -->
                    <div class="bg-white w-80 sm:w-96 rounded-lg shadow-black-custom p-6 relative">
                        <!-- Close Button -->
                        <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                            <i class="bi bi-x text-4xl"></i> 
                        </button>
                        
                        <h2 class="text-center text-pink-500 font-semibold text-lg mb-4">Filter</h2>

                        <form action="" method="get">
                            <div class="space-y-4">
                                <!-- Komoditas -->
                                <div class="flex flex-col">
                                    <label for="pilih_komoditas" class="block text-sm max-md:text-xs font-medium text-gray-700 mb-1">
                                        Pilih Komoditas
                                    </label>
                                    <select id="pilih_komoditas" class="select2 w-full rounded border border-gray-300 p-2 bg-white text-sm max-md:text-xs">
                                        <option value="" selected>Suket Teki</option>
                                        @foreach ($commodities as $commodity)
                                            <option value="{{ $commodity }}">{{ $commodity }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Periode -->
                                <div class="flex flex-col">
                                    <label for="pilih_periode" class="block text-sm max-md:text-xs font-medium text-gray-700 mb-1">
                                        Pilih Periode
                                    </label>
                                    <select id="pilih_periode" class="select2 w-full rounded border border-gray-300 p-2 bg-white text-sm max-md:text-xs" disabled>
                                        <option value="" disabled selected>April 2025</option>
                                        @foreach ($periods as $period)
                                            <option value="{{ $period }}">{{ $period }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 mt-10">
                                <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-2 text-sm max-md:p-1">
                                    Reset
                                </button>
                                <button type="submit" class="bg-pink-650 text-white rounded-lg w-20 p-2 text-sm max-md:p-1">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div> 
                </div> 
            </div> 
        </div>

    </div>
</div>

<!-- Chart Section -->
<main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
    <div class="w-full flex items-center gap-2 mb-4">
        <a href="javascript:history.back()" class="text-dark flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </a>
        <h3 class="text-xl font-bold max-md:text-lg">Hektar Luas Panen April 2025</h3>
    </div>

    <!-- Tombol Switch Produksi / Panen (DIBIARKAN) -->
    <div class="flex w-auto">
        <a href="{{ route('dtphp.produksi') }}">
            <button class="text-gray-400 rounded-t-xl bg-gray-100 px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.produksi') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2 max-md:left-2">
                Volume Produksi
            </button>
        </a>
        <a href="{{ route('dtphp.panen') }}">
            <button class="text-pink-500 rounded-t-xl bg-white px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
                Luas Panen
            </button>
        </a>
    </div>

    <!-- Chart Container -->
    <div class="w-full bg-white rounded shadow-md flex flex-col items-center justify-center p-8 max-md:p-4 relative border bg-gray-10 border-gray-20">
        <div class="flex flex-col items-center mb-3 font-bold text-green-910 text-center max-md:text-[12px]">
            <h3>Hektar Luas Panen April 2025</h3>
        </div>

        <div id="chart" class="w-full">
            {{-- Chart Here --}}
        </div>
    </div>

    <!-- Button Detail Data -->
    <div class="flex justify-start mt-6">
        <a href="{{ route('dtphp.detail.panen') }}">
            <button class="bg-yellow-550 text-white px-6 py-2 rounded-xl hover:bg-yellow-500 text-sm max-md:text-xs max-md:px-4 max-md:py-1">
                Lihat Detail Data
            </button>
        </a>
    </div>
</main>

</x-admin-layout>

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