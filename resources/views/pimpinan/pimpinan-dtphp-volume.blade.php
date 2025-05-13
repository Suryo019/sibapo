<x-pimpinan-layout>

        
    <div class="flex justify-between items-center gap-4 my-4 max-md:flex-wrap">
        <!-- Search Component -->
        <x-search></x-search>
    
        <div class="flex justify-end max-md:w-full">
            <x-filter></x-filter>
    
            <!-- Modal Background -->
            <x-filter-modal>
                <form action="" method="get">
                    <div class="space-y-4">
                        <!-- Pilih Komoditas -->
                        <div class="flex flex-col">
                            <label for="pilih_komoditas" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                                Pilih Komoditas
                            </label>
                            <select id="pilih_komoditas"
                                class="select2 w-full rounded-full border border-gray-300 p-2 bg-white text-sm max-md:text-xs">
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
                                class="select2 w-full rounded-full border border-gray-300 p-2 bg-white text-sm max-md:text-xs" disabled>
                                <option value="" disabled selected>April 2025</option>
                                @foreach ($periods as $period)
                                    <option value="{{ $period }}">{{ $period }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="w-full flex justify-end gap-3 mt-10">
                        <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-1">Reset</button>
                        <button type="submit" class="bg-pink-650 text-white rounded-lg w-20 p-1">Cari</button>
                    </div>
                </form>
            </x-filter-modal> 
        </div> 
    </div>
    
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
            <a href="{{ route('pimpinan.dashboard') }}" class="flex-shrink-0 text-dark">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
            <h3 class="text-xl font-extrabold text-center max-md:text-base">Volume Produksi</h3>
        </div>
    
        <!-- Tombol Switch Produksi / Panen -->
        <div class="flex w-auto">
            <a href="{{ route('pimpinan.dtphp-volume') }}">
                <button class="text-pink-500 rounded-t-xl bg-white px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.produksi') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
                    Volume Produksi
                </button>
            </a>
            <a href="{{ route('pimpinan.dtphp-panen') }}">
                <button class="text-gray-400 rounded-t-xl bg-gray-100 px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
                    Luas Panen
                </button>
            </a>
        </div>
    
        <!-- Chart Container -->
        <div class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8 max-md:p-4 relative z-10 border bg-gray-10 border-gray-20">
            <div class="flex items-center flex-col mb-3 font-bold text-green-910 text-center max-md:text-[12px]">
                <h3>Volume Produksi April 2025</h3>
            </div>
    
            <div id="chart" class="w-full">
                {{-- Chart --}}
            </div>
        </div>
    
    </main>
    
</x-pimpinan-layout>

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
                    name: 'Produksi',
                    data: produksi
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
                        text: 'Ton'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + ' ton';
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