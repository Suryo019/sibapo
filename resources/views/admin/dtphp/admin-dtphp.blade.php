<x-admin-layout>
  
      <!-- Dropdown -->
      <div class="flex justify-end my-4">
          <div class="flex gap-6 max-md:gap-4 items-end justify-end w-full">

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
                      <!-- Nama Pasar -->
                      <div class="flex flex-col">
                        <label for="pilih_pasar" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                          Pilih Pasar
                      </label>
                      <select id="pilih_pasar"
                          class="select2 w-36 max-md:w-28 rounded-full border border-gray-300 p-2 bg-white text-sm max-md:text-xs">
                          <option value="" disabled selected>Pilih Pasar</option>
                          <option value="Pasar Tanjung">Pasar Tanjung</option>
                          <!-- Add more options as needed -->
                      </select>
                      </div>

                      <!-- Periode -->
                      <div class="flex flex-col">
                        <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                          Pilih Periode
                      </label>
                      <select id="pilih_periode"
                          class="select2 w-36 max-md:w-28 rounded-full border border-gray-300 p-2 bg-white text-sm max-md:text-xs">
                          <option value="Januari 2025">Januari 2025</option>
                          <!-- Add more options as needed -->
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

          </div>
      </div>
  
      <!-- Chart Placeholder -->
      <div class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8 max-md:p-4 border bg-gray-10 border-gray-20">
          <div class="flex items-center flex-col mb-3 font-bold text-black text-center max-md:text-[12px]">
              <h3>Data Produksi Tanaman</h3>
              <h3><b id="pasar"></b> <b id="periode"></b></h3>
          </div>
  
          <!-- Placeholder saat chart belum tersedia -->
          <div id="chart_placeholder" class="text-gray-500 text-center text-sm max-md:text-xs">
              Silakan pilih pasar dan periode untuk menampilkan data grafik.
          </div>
  
          <div id="chart" class="w-full hidden">
              {{-- Chart --}}
          </div>
      </div>
  
      <!-- Button -->
      <div class="flex justify-center mt-6">
          <a href="{{ route('dtphp.detail.produksi') }}">
              <button class="bg-pink-500 text-white px-6 py-2 rounded-full hover:bg-pink-650 text-sm max-md:text-xs max-md:px-4 max-md:py-1">
                  Lihat Detail Data
              </button>
          </a>
      </div>
    </main>
  </x-admin-layout>
  
  <script>
var chart,debounceTimer;$("#pilih_pasar, #pilih_periode").on("change",(function(){clearTimeout(debounceTimer),debounceTimer=setTimeout((()=>{let e=$("#pilih_pasar").val(),t=$("#pilih_periode").val();$.ajax({type:"GET",url:"{{ route('api.dtphp.produksi') }}",data:{_token:"{{ csrf_token() }}",pasar:e,periode:t},success:function(a){let r=a.data;if(!r||0===r.length)return chart&&(chart.destroy(),chart=null),void $("#chart_placeholder").html('\n                <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">\n                  <h3 class="text-lg font-semibold text-gray-500">Data Tidak Ditemukan</h3>\n                  <p class="text-gray-400">Tidak ada data untuk periode yang dipilih.</p>\n                </div>\n              ');let o=r.map((e=>e.ton_produksi)),d=r.map((e=>e.jenis_tanaman));chart&&chart.destroy();var n={chart:{type:"bar",height:350,animations:{enabled:!0,easing:"easeinout",speed:800}},series:[{name:"Produksi (ton)",data:o}],xaxis:{categories:d,labels:{style:{fontSize:"12px"}}},yaxis:{title:{text:"Ton"}},tooltip:{y:{formatter:function(e){return e+" ton"}}}};$("#chart_placeholder").empty(),$("#chart").removeClass("hidden"),(chart=new ApexCharts(document.querySelector("#chart"),n)).render(),$("#pasar").text(e),$("#periode").text(t)},error:function(e){$("#chart_placeholder").html('\n              <div class="text-center p-4 border-2 border-dashed border-red-200 rounded-lg shadow-md bg-red-50">\n                <h3 class="text-lg font-semibold text-red-500">Error</h3>\n                <p class="text-red-400">Gagal memuat data. Silakan coba lagi.</p>\n              </div>\n            '),console.error("AJAX Error:",e.responseText)}})}),300)}));
  </script>