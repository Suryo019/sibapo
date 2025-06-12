<x-pimpinan-layout>

    <!-- Dropdown -->
    <div class="flex justify-end my-4">
      <div class="flex items-center justify-between w-full gap-6 max-md:flex-wrap max-md:gap-4">
        
        <!-- Search Component -->
        <x-search>Cari minggu...</x-search>

        <!-- Filter -->
        <div class="flex justify-end max-md:w-full">
          <x-filter />

          <!-- Modal Background -->
          <x-filter-modal>
            <form action="" method="get">
              <div class="space-y-4">
                
                <!-- Pilih Periode -->
                <div class="flex flex-col">
                  <label for="periode" class="block text-sm font-medium text-gray-700 mb-1">Pilih Periode</label>
                  <input type="month" value="{{ date('Y-m') }}" name="periode" id="periode" class="border border-black p-2 rounded bg-white w-full">
                </div>
              </div>
  
              <!-- Buttons -->
              <div class="w-full flex justify-end gap-3 mt-10">
                <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-1">
                  Reset
                </button>
                <button type="button" id="filterSubmitBtn" class="bg-pink-650 text-white rounded-lg w-20 p-1">
                  Cari
                </button>
              </div>
            </form></x-filter-modal> 
        </div> 
      </div> 
    </div>

    <!-- Chart Placeholder -->
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px] relative">
      <div class="w-full flex items-center justify-between gap-2 mb-5 max-md:flex-col max-md:items-start max-md:gap-1">
        <div class="flex items-center justify-start max-md:gap-3">
          <a href="javascript:history.back()" class="text-decoration-none text-dark flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
          </a>
          <h2 class="text-2xl font-semibold text-black max-md:text-xl max-md:text-center">
            DATA KETERSEDIAAN <span id="periode_placeholder"></span>
          </h2>
        </div>
      </div>

      <!-- Chart Card -->
      <div class="w-full flex items-center justify-center flex-col" id="chart_container">
            {{-- Diisi pake ajax --}}
      </div>
    </main>

</x-pimpinan-layout>

<script>
const periode=$("#periode"),search=$("#search");function toggleModal(){const e=document.getElementById("filterModal");e.classList.toggle("hidden"),e.classList.toggle("flex")}$("#filterBtn").on("click",(function(){$("#filterModal").toggleClass("hidden")}));let charts=[];function renderChartFromData(e){const t=e.data,a=$("#chart_container");a.empty(),charts.forEach((e=>e.destroy())),charts=[];const n=[];Object.values(t).forEach((e=>{e.forEach((e=>{n.includes(e.minggu)||n.push(e.minggu)}))})),n.sort(((e,t)=>e-t)),t&&0!==Object.keys(t).length?n.forEach(((e,n)=>{const o=t[e]||[],r=o.map((e=>e.nama_komoditas)),d=o.map((e=>e.ton_ketersediaan)),i=o.map((e=>e.ton_kebutuhan_perminggu)),s=`chart-minggu-${e}`;a.append(`\n        <div class="mb-5 w-full rounded-2xl bg-white shadow-md p-4 border">\n          <h2 class="text-center text-lg font-semibold text-gray-700 mb-2 keterangan_minggu">Minggu ke-${e}</h2>\n          <div id="${s}" class="shadow border rounded-md p-2 bg-white"></div>\n        </div>\n      `);const c={chart:{id:`${s}_${n}`,type:"line",height:350,toolbar:{show:!0,tools:{download:!0,selection:!0,zoom:!0,zoomin:!0,zoomout:!0,pan:!0,reset:!0,customIcons:[{icon:'<iconify-icon icon="teenyicons:pdf-solid"></iconify-icon>',index:-1,title:"Download PDF",class:"custom-download-pdf",click:function(t,a,o){ApexCharts.exec(`${s}_${n}`,"dataURI").then((({imgURI:t})=>{$.ajax({url:"/export-pdf-chart",type:"POST",data:{image:t,title:`Data Minggu ke-${e}`},xhrFields:{responseType:"blob"},success:function(e){const t=window.URL.createObjectURL(e),a=document.createElement("a");a.href=t,a.download="chart-export.pdf",document.body.appendChild(a),a.click(),a.remove()},error:function(){alert("Gagal mengunduh PDF")}})}))}}]}}},series:[{name:"Ketersediaan (ton)",data:d.length?d:[0]},{name:"Kebutuhan (ton)",data:i.length?i:[0]}],xaxis:{categories:r.length?r:["Tidak ada data"],labels:{style:{fontSize:"12px"}}},yaxis:{title:{text:"Ton"}},tooltip:{y:{formatter:e=>`${e} ton`}}},l=new ApexCharts(document.querySelector(`#${s}`),c);l.render(),charts.push(l)})):a.html('\n            <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">\n                <h3 class="text-lg font-semibold text-gray-500">Data Tidak Ditemukan</h3>\n                <p class="text-gray-400">Tidak ada data untuk kriteria yang dipilih.</p>\n            </div>\n        ')}function fetchDataAndRenderChart(){$.ajax({type:"GET",url:"{{ route('api.dkpp.index') }}",data:{_token:"{{ csrf_token() }}",periode:periode.val()},success:function(e){console.log(e),$("#periode_placeholder").html(`- ${e.periode.toUpperCase()}`),renderChartFromData(e)},error:function(e){$("#chart_container").html('\n          <div class="text-center p-4 border-2 border-dashed border-red-200 rounded-lg shadow-md bg-red-50">\n            <h3 class="text-lg font-semibold text-red-500">Error</h3>\n            <p class="text-red-400">Gagal memuat data. Silakan coba lagi.</p>\n          </div>\n        '),console.error("AJAX Error:",e.responseText)}})}$(document).ready((function(){fetchDataAndRenderChart()})),$("#filterSubmitBtn").on("click",(function(){fetchDataAndRenderChart()})),search.on("input",(function(){const e=$(this).val().toLowerCase();$(".keterangan_minggu").each((function(){$(this).text().toLowerCase().includes(e)?$(this).parent().removeClass("hidden"):$(this).parent().addClass("hidden")}))}));
</script>


