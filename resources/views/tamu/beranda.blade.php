{{-- @dd($data) --}}

<x-tamu-layout title="Beranda">
    <x-tamu-header></x-tamu-header>

    {{-- Chart Beranda --}}
    <section class="my-20 px-4 sm:px-8 md:px-16">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row items-center justify-evenly gap-6 text-center md:text-left lg:mx-32">
            <iconify-icon icon="icon-park-outline:trend-two" class="text-6xl md:text-7xl text-pink-650 max-md:hidden"></iconify-icon>

            <div class="flex flex-col items-center gap-2">
            <h2 class="text-3xl sm:text-5xl font-bold">Tren Harga</h2>
            <h3 class="text-xl sm:text-3xl font-semibold text-yellow-550" id="pasar_placeholder">Cabai Pasar Tanjung</h3>
            <h5 class="text-lg sm:text-2xl font-semibold text-gray-700" id="periode_placeholder">Januari 2025</h5>
            </div>

            <iconify-icon icon="healthicons:market-stall" class="text-6xl md:text-7xl text-pink-650 max-md:hidden"></iconify-icon>
        </div>

        {{-- Card Container --}}
        <div class="mt-10 bg-gray-10 border-2 border-gray-200 rounded-2xl p-6 lg:mx-32 shadow-sm">
            {{-- Search & Filter --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            {{-- Search --}}
            <div class="flex items-center border bg-white rounded-[10px] w-full lg:w-64 h-9 px-5">
                <input type="text" id="search" placeholder="Cari bahan pokok..." class="flex-grow outline-none bg-transparent">
                <span class="bi bi-search text-gray-700"></span>
            </div>

            {{-- Filter + Modal --}}
            <div class="w-full md:w-auto flex justify-end">
                <x-filter></x-filter>

                <x-filter-modal>
                    <form action="" method="get" class="space-y-5">
                        {{-- Pilih Pasar --}}
                        <div class="flex flex-col">
                        <label for="pilih_pasar" class="text-sm font-medium mb-1 max-md:text-xs">Pilih Pasar</label>
                        <select name="pasar" id="pilih_pasar" class="border border-gray-300 p-2 rounded bg-white w-full text-sm max-md:text-xs">
                            <option value="" disabled {{ old('pasar') ? '' : 'selected' }}>Pilih Pasar</option>
                            @foreach ($markets as $index => $market)
                            <option value="{{ $market->nama_pasar }}"
                                {{ old('pasar') == $market->nama_pasar ? 'selected' : ($index == 0 && !old('pasar') ? 'selected' : '') }}>
                                {{ $market->nama_pasar }}
                            </option>
                            @endforeach
                        </select>
                        </div>

                        {{-- Pilih Periode --}}
                        <div class="flex flex-col">
                        <label for="pilih_periode" class="text-sm font-medium mb-1 max-md:text-xs">Pilih Periode</label>
                        <input 
                            type="month" 
                            name="periode" 
                            id="pilih_periode" 
                            value="{{ old('periode', date('Y-m')) }}" 
                            class="border border-gray-300 w-full p-2 rounded bg-white text-sm max-md:text-xs">
                        </div>

                        {{-- Buttons --}}
                        <div class="flex justify-end gap-4 mt-6">
                        <button type="reset" class="bg-yellow-550 text-white px-4 py-1 rounded-lg hover:opacity-90 w-full md:w-24 text-sm">Reset</button>
                        <button type="button" id="filter_btn" class="bg-pink-650 text-white px-4 py-1 rounded-lg hover:opacity-90 w-full md:w-24 text-sm">Cari</button>
                        </div>
                    </form>
                </x-filter-modal>
            </div>
            </div>

            {{-- Chart Grid --}}
            <div id="chart_container" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mt-6">
            {{-- AJAX chart will be inserted here --}}
            </div>
        </div>
    </section>


    {{-- Body --}}
    <div class="relative mt-40 mb-20 px-4 sm:px-8 md:px-16 lg:mx-32 lg:px-0 text-center lg:text-left">
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight">
            <span class="block sm:hidden">
                Harga rata-rata<br>
                komoditas hari ini di Jember
            </span>
            <span class="hidden sm:inline">
                Harga rata-rata bahan pokok hari ini di Jember
            </span>
        </h1>
        <h5 class="text-sm sm:text-base text-slate-600 mt-3 sm:mt-5 mb-5 sm:mb-7">
            Harga dibandingkan dengan hari sebelumnya <b>{{ $kemarin }}</b>
        </h5>

        {{-- Daftar Komoditas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 2xl:grid-cols-4 gap-6 justify-items-center">
            @foreach ($data as $item)
            <div class="bg-white rounded-3xl shadow-md overflow-hidden border py-3 px-2 w-[90%] sm:w-64 md:w-72 lg:w-80 xl:w-72 h-auto">
                <div class="h-[40vw] sm:h-40 md:h-44 lg:h-48 flex justify-center items-center overflow-hidden">
                    @if ($item['gambar_komoditas'])
                        <img src="{{ asset('storage/' . $item['gambar_komoditas']) }}" alt="komoditas" class="object-cover">
                    @else
                        <img src="{{ asset('storage/img/landscape-placeholder.svg') }}" alt="komoditas" class="object-cover w-full h-full">
                    @endif
                </div>
                <div class="p-3">
                    <p class="text-gray-600 text-sm md:text-base">{{ $item['komoditas'] }}</p>
                    <h3 class="text-lg md:text-xl lg:text-2xl font-extrabold mb-2">
                        Rp. {{ number_format($item['rata_rata_hari_ini'], 0, ',', '.') }}/kg
                    </h3>
                    @php
                        $statusClass = match($item['status']) {
                            'Naik' => 'bg-green-200 text-green-600',
                            'Turun' => 'bg-red-200 text-red-600',
                            'Stabil' => 'bg-blue-200 text-blue-600',
                            default => 'bg-slate-200 text-slate-600',
                        };
                        $icon = match($item['status']) {
                            'Naik' => 'bi-arrow-up',
                            'Turun' => 'bi-arrow-down',
                            'Stabil' => 'bi-circle',
                            default => '',
                        };
                    @endphp
                    <span class="flex justify-center items-center {{ $statusClass }} w-full rounded-full p-2 font-semibold text-sm md:text-base gap-2">
                        @if ($icon)
                            <i class="bi {{ $icon }}"></i>
                        @endif
                        {{ $item['status'] }}
                        @if($item['selisih'])
                            Rp. {{ number_format($item['selisih'], 0, ',', '.') }}
                        @endif
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        

    </div>
</x-tamu-layout>

<script>
let chart,debounceTimer,pasar=$("#pilih_pasar").val(),periode=$("#pilih_periode").val();const search=$("#search");function renderCharts(e){const a=$("#chart_container");a.empty(),e&&0!==Object.keys(e).length?Object.keys(e).forEach(((t,r)=>{const n=e[t];n.sort(((e,a)=>e.hari-a.hari));const i=n.map((e=>e.hari)),o=n.map((e=>e.kg_harga)),d=`chart_${r}`;a.append(`\n                <div class="mb-5 w-full rounded-2xl bg-white shadow-md p-4 border">\n                    <h4 class="text-center text-md font-bold mb-2 jenis_bahan_pokok_col">${t}</h4>\n                    <div id="${d}" class="w-full"></div>\n                </div>\n            `);new ApexCharts(document.querySelector(`#${d}`),{chart:{type:"line",height:300,animations:{enabled:!0,easing:"easeinout",speed:800}},series:[{name:"Harga (Rp)",data:o}],xaxis:{title:{text:"Hari"},categories:i,labels:{style:{fontSize:"12px"}}},yaxis:{title:{text:"Harga (Rp)"},labels:{formatter:function(e){return"Rp "+e.toLocaleString("id-ID")}}},tooltip:{y:{formatter:function(e){return"Rp "+e.toLocaleString("id-ID")}}}}).render()})):a.html('\n                <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">\n                    <h3 class="text-lg font-semibold text-gray-500">Data Tidak Ditemukan</h3>\n                    <p class="text-gray-400">Tidak ada data untuk kriteria yang dipilih.</p>\n                </div>\n            ')}function fetchChartData(e,a){$.ajax({type:"GET",url:"{{ route('api.dpp.index') }}",data:{_token:"{{ csrf_token() }}",pasar:e,periode:a},success:function(a){$("#periode_placeholder").html(`${a.periode.toUpperCase()}`),$("#pasar_placeholder").html(e.toUpperCase()),renderCharts(a.data)},error:function(){$("#chart_container").html('\n                    <div class="text-center p-4 border-2 border-dashed border-red-300 rounded-lg shadow-md bg-red-50">\n                        <h3 class="text-lg font-semibold text-red-500">Gagal Memuat Data</h3>\n                        <p class="text-red-400">Terjadi kesalahan saat mengambil data.</p>\n                    </div>\n                ')}})}function toggleModal(){$("#filterModal").toggleClass("hidden flex")}fetchChartData(pasar,periode),$("#filter_btn").on("click",(function(){clearTimeout(debounceTimer),debounceTimer=setTimeout((()=>{const e=$("#pilih_pasar").val(),a=$("#pilih_periode").val();e&&a&&(pasar=e,periode=a,fetchChartData(pasar,periode))}),300)})),$("#filterBtn").on("click",toggleModal),search.on("input",(function(){const e=$(this).val().toLowerCase();$(".jenis_bahan_pokok_col").each((function(){$(this).text().toLowerCase().includes(e)?$(this).parent().removeClass("hidden"):$(this).parent().addClass("hidden")}))}));
</script>