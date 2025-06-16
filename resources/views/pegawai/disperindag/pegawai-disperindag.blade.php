<x-pegawai-layout title="Visualisasi Data Dinas">
    {{-- Abaikan DULU! --}}
    <div class="flex justify-between items-center gap-4 my-4 ">
        <!-- Search Component -->
        <x-search>Cari bahan pokok...</x-search>
    
        {{-- Filter --}}
        <div class="flex justify-end max-md:w-full">
            <x-filter></x-filter>
    
            <!-- Modal Background -->
            <x-filter-modal>
                <form action="" method="get">
                    <div class="space-y-4">
                        <!-- Nama Pasar -->
                        <div class="flex flex-col">
                            <label for="pilih_pasar" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">Pilih Pasar</label>
                            <select name="pasar" id="pilih_pasar" class="border border-black p-2 rounded-lg bg-white w-full select2 text-sm max-md:text-xs">
                                <option value="" disabled {{ old('pasar') ? '' : 'selected' }}>Pilih Pasar</option>
                                @foreach ($markets as $index => $market)
                                    <option value="{{ $market->nama_pasar }}"
                                        {{ old('pasar') == $market->nama_pasar ? 'selected' : ($index == 0 && !old('pasar') ? 'selected' : '') }}>
                                        {{ $market->nama_pasar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Periode -->
                        <div class="flex flex-col">
                            <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">Pilih Periode</label>
                            <input 
                            type="month" 
                            name="periode" 
                            id="pilih_periode" 
                            value="{{ old('periode', date('Y-m')) }}" 
                            class="border w-full max-md:w-full p-2 rounded bg-white text-xs">
                        </div>
                    </div>

                    <div class="w-full flex justify-end gap-3 mt-10">
                        <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-1 max-md:w-1/2">Reset</button>
                        <button type="button" id="filter_btn" class="bg-pink-650 text-white rounded-lg w-20 p-1 max-md:w-1/2">Cari</button>
                    </div>
                </form>
            </x-filter-modal>
        </div>
    </div>
    
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center justify-between gap-2 mb-5 max-md:flex-col max-md:items-start max-md:gap-1">
            <div class="flex items-center justify-start max-md:gap-3">
                <a href="javascript:history.back()" class="text-decoration-none text-dark flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6 max-md:w-5 max-md:h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>                      
                </a>
                <h2 class="text-2xl font-semibold text-black max-md:text-lg w-full">
                    DATA AKTIVITAS HARGA <span id="pasar_placeholder"></span> <span id="periode_placeholder"></span>
                </h2>
            </div>
            <div class="max-md:my-3">
                <a href="{{ route('pegawai.disperindag.detail') }}" class="flex items-center text-lg font-semibold max-md:text-base w-full text-pink-650 gap-3">LIHAT DETAIL <i class="bi bi-arrow-right font-bold"></i></a>
            </div>
        </div>
    
        <!-- Chart Placeholder -->
        <div class="w-full flex items-center justify-center flex-col" id="chart_container">
        {{-- <div id="chart_container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-4"> --}}
            {{-- Diisi pake ajax --}}
        </div>
    </main>
    

    

</x-pegawai-layout>

<script>
let chart,debounceTimer,pasar=$("#pilih_pasar").val(),periode=$("#pilih_periode").val();const search=$("#search");function renderCharts(e){const t=$("#chart_container");t.empty(),e&&0!==Object.keys(e).length?Object.keys(e).forEach(((a,o)=>{const n=e[a];n.sort(((e,t)=>e.hari-t.hari));const r=n.map((e=>e.hari)),i=n.map((e=>e.kg_harga)),d=`chart_${o}`;t.append(`\n                <div class="mb-5 w-full rounded-2xl bg-white shadow-md p-4 border">\n                    <h4 class="text-center text-md font-bold mb-2 jenis_bahan_pokok_col">${a}</h4>\n                    <div id="${d}" class="w-full"></div>\n                </div>\n            `);new ApexCharts(document.querySelector(`#${d}`),{chart:{id:`${d}_${o}`,type:"line",height:350,toolbar:{show:!0,tools:{download:!0,selection:!0,zoom:!0,zoomin:!0,zoomout:!0,pan:!0,reset:!0,customIcons:[{icon:'<iconify-icon icon="teenyicons:pdf-solid"></iconify-icon>',index:-1,title:"Download PDF",class:"custom-download-pdf",click:function(e,t,n){ApexCharts.exec(`${d}_${o}`,"dataURI").then((({imgURI:e})=>{$.ajax({url:"/export-pdf-chart",type:"POST",data:{image:e,title:a},xhrFields:{responseType:"blob"},success:function(e){const t=window.URL.createObjectURL(e),a=document.createElement("a");a.href=t,a.download="chart-export.pdf",document.body.appendChild(a),a.click(),a.remove()},error:function(){alert("Gagal mengunduh PDF")}})}))}}]}},animations:{enabled:!0,easing:"easeinout",speed:800}},series:[{name:"Harga (Rp)",data:i}],xaxis:{title:{text:"Hari"},categories:r,labels:{style:{fontSize:"12px"}}},yaxis:{title:{text:"Harga (Rp)"},labels:{formatter:function(e){return"Rp "+e.toLocaleString("id-ID")}}},tooltip:{y:{formatter:function(e){return"Rp "+e.toLocaleString("id-ID")}}}}).render()})):t.html('\n                <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">\n                    <h3 class="text-lg font-semibold text-gray-500">Data Tidak Ditemukan</h3>\n                    <p class="text-gray-400">Tidak ada data untuk kriteria yang dipilih.</p>\n                </div>\n            ')}function fetchChartData(e,t){$.ajax({type:"GET",url:"{{ route('api.dpp.index') }}",data:{_token:"{{ csrf_token() }}",pasar:e,periode:t},success:function(t){$("#periode_placeholder").html(`- ${t.periode.toUpperCase()}`),$("#pasar_placeholder").html(e.toUpperCase()),renderCharts(t.data)},error:function(){$("#chart_container").html('\n                    <div class="text-center p-4 border-2 border-dashed border-red-300 rounded-lg shadow-md bg-red-50">\n                        <h3 class="text-lg font-semibold text-red-500">Gagal Memuat Data</h3>\n                        <p class="text-red-400">Terjadi kesalahan saat mengambil data.</p>\n                    </div>\n                ')}})}function toggleModal(){$("#filterModal").toggleClass("hidden flex")}fetchChartData(pasar,periode),$("#filter_btn").on("click",(function(){clearTimeout(debounceTimer),debounceTimer=setTimeout((()=>{const e=$("#pilih_pasar").val(),t=$("#pilih_periode").val();e&&t&&(pasar=e,periode=t,fetchChartData(pasar,periode))}),300)})),$("#filterBtn").on("click",toggleModal),search.on("input",(function(){const e=$(this).val().toLowerCase();$(".jenis_bahan_pokok_col").each((function(){$(this).text().toLowerCase().includes(e)?$(this).parent().removeClass("hidden"):$(this).parent().addClass("hidden")}))}));
</script>
