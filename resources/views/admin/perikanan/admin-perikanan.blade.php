<x-admin-layout>
  
  <!-- Dropdown -->
  <div class="flex justify-end my-4">
    <div class="flex items-center justify-between w-full gap-6  max-md:gap-4">
      <!-- Search Component -->
      <div></div>

      {{-- Filter --}}
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
      
  <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px] relative">
    <div class="w-full flex items-center justify-between gap-2 mb-5 max-md:flex-col max-md:items-start max-md:gap-1">
      <div class="flex items-center justify-start max-md:gap-3">
        <a href="javascript:history.back()" class="text-decoration-none text-dark flex-shrink-0">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
        </a>
        <h2 class="text-2xl font-semibold text-black max-md:text-xl max-md:text-center">
          DATA VOLUME PRODUKSI IKAN <span id="periode_placeholder"></span>
        </h2>
      </div>
      
      <div class="max-md:my-3">
        <a href="{{ route('perikanan.detail') }}" class="flex items-center text-lg font-semibold max-md:text-base w-full text-pink-650 gap-3">LIHAT DETAIL <i class="bi bi-arrow-right font-bold"></i></a>
      </div>
    </div>

    <!-- Chart Card -->
    <div class="w-full flex items-center justify-center flex-col" id="chart_container">
      {{-- <div id="chart_container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-4"> --}}
          {{-- Diisi pake ajax --}}
    </div>
  </main>
</x-admin-layout>

<script>
const periode=$("#pilih_periode"),container=$("#chart_container");function toggleModal(){const e=document.getElementById("filterModal");e.classList.toggle("hidden"),e.classList.toggle("flex")}$("#filterBtn").on("click",(function(){$("#filterModal").toggleClass("hidden")}));let charts=[];function renderChartFromData(e){const t=e.data;if(container.empty(),!t||0===Object.keys(t).length)return void container.html('\n        <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">\n          <h3 class="text-lg font-semibold text-gray-500">Data Tidak Ditemukan</h3>\n          <p class="text-gray-400">Tidak ada data untuk kriteria yang dipilih.</p>\n        </div>\n      ');const o=[],a={};Object.keys(t).forEach((e=>{t[e].forEach((t=>{const n=t.jenis_ikan;o.includes(n)||o.push(n),a[e]||(a[e]={}),a[e][n]=(a[e][n]||0)+t.ton_produksi}))}));const n=Object.keys(a).map((e=>({name:e,data:o.map((t=>a[e][t]||0))}))),r="chart-gabungan",i=periode.val(),[d,c]=i.split("-"),s=`Produksi Ikan Bulan ${["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"][parseInt(c)-1]} ${d}`;$("#chart_container").append(`\n      <div class="mb-5 w-full rounded-2xl bg-white shadow-md p-4 border">\n        <h2 class="text-center text-lg font-semibold text-gray-700 mb-2">${s}</h2>\n        <div id="${r}" class="shadow border rounded-md p-2 bg-white"></div>\n      </div>\n    `);const l={chart:{id:`${r}_main`,type:"bar",height:450,stacked:!1,toolbar:{show:!0,tools:{download:!0,selection:!0,zoom:!0,zoomin:!0,zoomout:!0,pan:!0,reset:!0,customIcons:[{icon:'<iconify-icon icon="teenyicons:pdf-solid"></iconify-icon>',index:-1,title:"Download PDF",class:"custom-download-pdf",click:function(e,t,o){ApexCharts.exec(`${r}_main`,"dataURI").then((({imgURI:e})=>{$.ajax({url:"/export-pdf-chart",type:"POST",data:{_token:"{{ csrf_token() }}",image:e,title:s},xhrFields:{responseType:"blob"},success:function(e){const t=window.URL.createObjectURL(e),o=document.createElement("a");o.href=t,o.download=`${s.replace(/\s+/g,"_")}_${(new Date).toISOString().split("T")[0]}.pdf`,document.body.appendChild(o),o.click(),o.remove(),window.URL.revokeObjectURL(t)},error:function(e){console.error("PDF Export Error:",e.responseText),alert("Gagal mengunduh PDF. Silakan coba lagi.")}})})).catch((function(e){console.error("Chart image generation error:",e),alert("Gagal menggenerate gambar chart untuk PDF.")}))}}]}},animations:{enabled:!0,easing:"easeinout",speed:800},selection:{enabled:!0,type:"x",fill:{color:"#24292e",opacity:.1},stroke:{width:1,dashArray:3,color:"#24292e",opacity:.4}},zoom:{enabled:!0,type:"x",autoScaleYaxis:!0}},series:n,xaxis:{categories:o,title:{text:"Jenis Ikan"}},yaxis:{title:{text:"Produksi (Ton)"},labels:{formatter:e=>e.toLocaleString("id-ID")+" Ton"}},tooltip:{y:{formatter:e=>`${e.toLocaleString("id-ID")} ton`}},legend:{position:"top",onItemClick:{toggleDataSeries:!0}},responsive:[{breakpoint:768,options:{chart:{height:300},legend:{position:"bottom"}}}]},p=new ApexCharts(document.querySelector(`#${r}`),l);p.render(),charts.push(p)}function fetchDataAndRenderChart(){$.ajax({type:"GET",url:"{{ route('api.dp.index') }}",data:{_token:"{{ csrf_token() }}",periode:periode.val()},success:function(e){console.log(e),$("#periode_placeholder").html(`- ${e.periode.toUpperCase()}`),renderChartFromData(e)},error:function(e){$("#chart_container").html('\n          <div class="text-center p-4 border-2 border-dashed border-red-200 rounded-lg shadow-md bg-red-50">\n            <h3 class="text-lg font-semibold text-red-500">Error</h3>\n            <p class="text-red-400">Gagal memuat data. Silakan coba lagi.</p>\n          </div>\n        '),console.error("AJAX Error:",e.responseText)}})}$(document).ready((function(){fetchDataAndRenderChart()})),$("#filterSubmitBtn").on("click",(function(){charts.forEach((e=>{e&&e.destroy()})),charts=[],fetchDataAndRenderChart()}));
</script>