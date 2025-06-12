<x-admin-layout>
    
<!-- Dropdown Section -->
<div class="flex flex-col gap-4 my-4 w-full">
    <div class="flex gap-6 max-md:gap-4 items-end justify-between w-full tabs">
        <!-- Search Component -->
        <x-search>
            Cari tanaman...
        </x-search>

        <!-- Filter Component -->
        <div class="flex justify-end">
            <div class="relative flex justify-end">
                <x-filter></x-filter>
  
                <!-- Modal Background -->
                <x-filter-modal>
                  <form action="" method="get">
                    <div class="space-y-4">
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
                      <button type="button" id="filterSubmitBtn" class="bg-pink-650 text-white rounded-lg w-20 p-1 max-md:w-1/2">Cari</button>
                    </div>
                </form>
                </x-filter-modal> 
            </div> 
          </div>
    </div>
</div>  

<!-- Chart Section -->
<main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px] relative">
    <div class="w-full flex items-center justify-between gap-2 mb-5 max-md:flex-col max-md:items-start max-md:gap-1">
      <div class="flex items-center justify-start max-md:gap-3">
        <a href="javascript:history.back()" class="text-decoration-none text-dark flex-shrink-0">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
        </a>
        <h2 class="text-2xl font-semibold text-black max-md:text-xl max-md:text-center">
          DATA LUAS PANEN TANAMAN <span id="periode_placeholder"></span>
        </h2>
      </div>    
      <div class="max-md:my-3">
        <a href="{{ route('dtphp.detail.panen') }}" class="flex items-center text-lg font-semibold max-md:text-base w-full text-pink-650 gap-3">LIHAT DETAIL <i class="bi bi-arrow-right font-bold"></i></a>
      </div>
    </div>

    <!-- Tombol Switch -->
    <div class="flex w-auto ml-4" id = "switch_button">
      <a href="{{ route('dtphp.produksi') }}">
          <button class="text-gray-400 rounded-t-xl bg-gray-100 px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2 max-md:left-2">
              Volume Produksi
          </button>
      </a>
      <a href="{{ route('dtphp.panen') }}">
          <button class="text-pink-500 rounded-t-xl bg-white px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
              Luas Panen
          </button>
      </a>
    </div>

    <!-- Chart Card -->
    <div class="w-full flex items-center justify-center flex-col" id="chart_container">
      {{-- <div id="chart_container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-4"> --}}
          {{-- Diisi pake ajax --}}
    </div>
</main>

</x-admin-layout>

<script>
    const periode=$("#pilih_periode"),container=$("#chart_container");function toggleModal(){const e=document.getElementById("filterModal");e.classList.toggle("hidden"),e.classList.toggle("flex")}$("#filterBtn").on("click",(function(){$("#filterModal").toggleClass("hidden")}));let charts=[];function renderChartFromData(e){const t=e.data;if(container.empty(),!t||0===Object.keys(t).length)return container.html('\n          <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">\n            <h3 class="text-lg font-semibold text-gray-500">Data Tidak Ditemukan</h3>\n            <p class="text-gray-400">Tidak ada data untuk kriteria yang dipilih.</p>\n          </div>\n        '),void $("#switch_button").addClass("hidden");$("#switch_button").removeClass("hidden");const a=[],n={};Object.keys(t).forEach((e=>{t[e].forEach((t=>{const o=t.jenis_tanaman;a.includes(o)||a.push(o),n[e]||(n[e]={}),n[e][o]=(n[e][o]||0)+t.hektar_luas_panen}))}));const o=Object.keys(n).map((e=>({name:e,data:a.map((t=>n[e][t]||0))}))),r="chart-gabungan",i=periode.val(),[d,s]=i.split("-"),c=`Luas Panen Tanaman Bulan ${["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"][parseInt(s)-1]} ${d}`;$("#chart_container").append(`\n        <div class="mb-5 w-full rounded-2xl bg-white shadow-md p-4 border">\n          <h2 class="text-center text-lg font-semibold text-gray-700 mb-2">${c}</h2>\n          <div id="${r}" class="shadow border rounded-md p-2 bg-white"></div>\n        </div>\n      `);const l={chart:{id:`${r}_main`,type:"bar",height:450,stacked:!1,toolbar:{show:!0,tools:{download:!0,selection:!0,zoom:!0,zoomin:!0,zoomout:!0,pan:!0,reset:!0,customIcons:[{icon:'<iconify-icon icon="teenyicons:pdf-solid"></iconify-icon>',index:-1,title:"Download PDF",class:"custom-download-pdf",click:function(e,t,a){ApexCharts.exec(`${r}_main`,"dataURI").then((({imgURI:e})=>{$.ajax({url:"/export-pdf-chart",type:"POST",data:{_token:"{{ csrf_token() }}",image:e,title:c},xhrFields:{responseType:"blob"},success:function(e){const t=window.URL.createObjectURL(e),a=document.createElement("a");a.href=t,a.download=`${c.replace(/\s+/g,"_")}_${(new Date).toISOString().split("T")[0]}.pdf`,document.body.appendChild(a),a.click(),a.remove(),window.URL.revokeObjectURL(t)},error:function(e){console.error("PDF Export Error:",e.responseText),alert("Gagal mengunduh PDF. Silakan coba lagi.")}})})).catch((function(e){console.error("Chart image generation error:",e),alert("Gagal menggenerate gambar chart untuk PDF.")}))}}]}},animations:{enabled:!0,easing:"easeinout",speed:800},selection:{enabled:!0,type:"x",fill:{color:"#24292e",opacity:.1},stroke:{width:1,dashArray:3,color:"#24292e",opacity:.4}},zoom:{enabled:!0,type:"x",autoScaleYaxis:!0}},series:o,xaxis:{categories:a,title:{text:"Jenis Tanaman"}},yaxis:{title:{text:"Luas (Ha)"},labels:{formatter:e=>e.toLocaleString("id-ID")+" Ha"}},tooltip:{y:{formatter:e=>`${e} ha`}},legend:{position:"top",onItemClick:{toggleDataSeries:!0}},responsive:[{breakpoint:768,options:{chart:{height:300},legend:{position:"bottom"}}}]};new ApexCharts(document.querySelector(`#${r}`),l).render()}function fetchDataAndRenderChart(){$.ajax({type:"GET",url:"{{ route('api.dtphp.panen') }}",data:{_token:"{{ csrf_token() }}",periode:periode.val()},success:function(e){$("#periode_placeholder").html(`- ${e.periode.toUpperCase()}`),renderChartFromData(e)},error:function(e){$("#chart_container").html('\n            <div class="text-center p-4 border-2 border-dashed border-red-200 rounded-lg shadow-md bg-red-50">\n              <h3 class="text-lg font-semibold text-red-500">Error</h3>\n              <p class="text-red-400">Gagal memuat data. Silakan coba lagi.</p>\n            </div>\n          '),console.error("AJAX Error:",e.responseText)}})}$(document).ready((function(){fetchDataAndRenderChart()})),$("#filterSubmitBtn").on("click",(function(){fetchDataAndRenderChart()}));
  
    // Search
    // search.on("input", function () {
    //       const input_value = $(this).val().toLowerCase();
    //       let nama_tanaman = $(".nama_tanaman");
  
    //       nama_tanaman.each(function () {
    //           let item_text = $(this).text().toLowerCase();
  
    //           if (item_text.includes(input_value)) {
    //               $(this).parent().removeClass("hidden");
    //           } else {
    //               $(this).parent().addClass("hidden");
    //           }
    //       });
    //   });
</script>