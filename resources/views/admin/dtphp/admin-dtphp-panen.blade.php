<x-admin-layout>
    <main class="flex-1 p-6 max-md:p-4">
        {{-- <h2 class="text-2xl font-semibold text-green-900 mb-4 max-md:mb-10 max-md:text-xl max-md:text-center">{{ $title }}</h2> --}}
        
        <!-- Tombol Switch Produksi / Panen -->
        <div class="flex gap-4 mb-4">
            <a href="{{ route('dtphp.produksi') }}">
                <button class="text-gray-400 rounded-t-md bg-gray-100 px-4 py-3 relative top-40 shadow-md left-10 text-sm {{ request()->routeIs('dtphp.detail.produksi') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2 max-md:left-2">
                    Volume Produksi
                </button>
            </a>
            <a href="{{ route('dtphp.panen') }}">
                <button class="text-pink-500 rounded-t-md bg-white px-4 py-3 shadow-md relative top-40 left-6 text-sm {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2 ">
                    Luas Panen
                </button>
            </a>
        </div>
    
        <!-- Dropdown -->
        <div class="flex justify-end my-4">
            <div class="flex flex-wrap gap-6 max-md:gap-4 items-end justify-between w-full">

                <div class="flex items-center border bg-gray-100 rounded w-full lg:w-64 h-9 px-3">
                    <input type="text" placeholder="Cari..." class="flex-grow outline-none rounded-full bg-gray-100">
                    <span class="bi bi-search pr-2 bg-gray-100"></span>
                </div>

                <!-- Button -->
                <button onclick="toggleModal()" class="px-4 py-2 bg-pink-500 text-white rounded-lg shadow hover:bg-pink-600">
                    <i class="bi bi-funnel-fill text-xl"></i>
                    Filter
                    <i class="bi bi-chevron-down text-xs"></i>
                </button>

                <!-- Modal Background -->
                <div id="filterModal" class="fixed inset-0 bg-black bg-opacity-30 hidden items-center justify-center z-50">
                    <!-- Modal Content -->
                    <div class="bg-white w-96 rounded-lg shadow-lg p-6 relative">
                        <!-- Close Button -->
                        <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                            <i class="bi bi-x text-4xl"></i> 
                        </button>
                        
                        <h2 class="text-center text-pink-500 font-semibold text-lg mb-4">
                            <i class="bi bi-funnel-fill text-xl"></i>
                            Filter
                            <i class="bi bi-chevron-down text-xs"></i>
                        </h2>

                        <div class="space-y-4">
                            <!-- Nama komoditas -->
                            <div class="flex flex-col">
                                <label for="pilih_komoditas" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                                    Pilih Komoditas
                                </label>
                                <select id="pilih_komoditas"
                                    class="select2 w-full max-md:w-28 rounded-full border border-gray-300 p-2 bg-white text-sm max-md:text-xs">
                                    <option value="" selected>Suket Teki</option>
                                    @foreach ($commodities as $commodity)
                                        <option value="{{ $commodity }}">{{ $commodity }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Periode -->
                            <div class="flex flex-col">
                                <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                                    Pilih Periode
                                </label>
                                <select id="pilih_periode"
                                    class="select2 w-full max-md:w-28 rounded-full border border-gray-300 p-2 bg-white text-sm max-md:text-xs" disabled>
                                    <option value="" disabled selected>April 2025</option>
                                    @foreach ($periods as $period)
                                        <option value="{{ $period }}">{{ $period }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function toggleModal() {
                        const modal = document.getElementById("filterModal");
                        modal.classList.toggle("hidden");
                        modal.classList.toggle("flex");
                    }
                </script>

                <!-- Pilih Komoditas -->
                {{-- <div class="flex flex-col">
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
                </div> --}}

                <!-- Pilih Periode -->
                {{-- <div class="flex flex-col">
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
                </div> --}}
            </div>
        </div>

        <!-- Chart Container-->
        <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
            <div class="w-full flex items-center gap-2 mb-4">
                <a href="javascript:history.back()" class="text-decoration-none text-dark flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>                      
                </a>        
                <h3>Hektar Luas Panen April 2025</h3>
            </div>
    
        <div class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8 max-md:p-4 relative z-10">
            <div class="flex items-center flex-col mb-3 font-bold text-green-910 text-center max-md:text-[12px]">
                <h3>Hektar Luas Panen April 2025</h3>
            </div>

            <div id="chart" class="w-full">
                {{-- Chart --}}
            </div>
        </div>
    
        <!-- Button-->
        <div class="flex justify-start mt-6">
            <a href="{{ route('dtphp.detail.panen') }}">
                <button class="bg-yellow-550 text-white px-6 py-2 rounded hover:bg-yellow-500 text-sm max-md:text-xs max-md:px-4 max-md:py-1">
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
</script>