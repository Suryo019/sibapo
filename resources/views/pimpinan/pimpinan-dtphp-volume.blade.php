<x-pimpinan-layout>
        
<!-- Dropdown Section -->
<div class="flex flex-col gap-4 my-4 w-full">
    <div class="flex gap-6 max-md:gap-4 items-end justify-between w-full tabs">
      <div></div>

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

<main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px] relative">
    <div class="w-full flex items-center justify-between gap-2 mb-5 max-md:flex-col max-md:items-start max-md:gap-1">
      <div class="flex items-center justify-start max-md:gap-3">
        <a href="javascript:history.back()" class="text-decoration-none text-dark flex-shrink-0">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
        </a>
        <h2 class="text-2xl font-semibold text-black max-md:text-xl max-md:text-center">
          DATA VOLUME PRODUKSI TANAMAN <span id="periode_placeholder"></span>
        </h2>
      </div>    

        <!-- Tombol Switch (TIDAK DIUBAH) -->
        <div class="flex w-auto">
            <a href="{{ route('pimpinan.dtphp-volume') }}">
                <button class="text-pink-500 rounded-t-xl bg-white px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.produksi') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2 max-md:left-2">
                    Volume Produksi
                </button>
            </a>
            <a href="{{ route('pimpinan.dtphp-panen') }}">
                <button class="text-gray-400 rounded-t-xl bg-gray-100 px-4 py-3 shadow-md text-sm border bg-gray-10 border-gray-20 {{ request()->routeIs('dtphp.detail.panen') ? 'font-bold' : '' }} max-md:text-xs max-md:px-3 max-md:py-2">
                    Luas Panen
                </button>
            </a>
        </div>  
    </div>

    <!-- Chart Card -->
    <div class="w-full flex items-center justify-center flex-col" id="chart_container">
      {{-- <div id="chart_container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-4"> --}}
          {{-- Diisi pake ajax --}}
    </div>
</main>
</x-pimpinan-layout>

<script>
    const periode = $('#pilih_periode');
    const search = $('#search');
    const container = $('#chart_container');
  
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
  
    let charts = [];
  
    // Fungsi Render Chart dari Response
    function renderChartFromData(response) {
      const dataset = response.data;
      container.empty();

      if (!dataset || Object.keys(dataset).length === 0) {
        container.html(`
          <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-500">Data Tidak Ditemukan</h3>
            <p class="text-gray-400">Tidak ada data untuk kriteria yang dipilih.</p>
          </div>
        `);
        return;
      }

      // Gabung semua data dalam satu chart
      const labels = []; // jenis tanaman
      const seriesMap = {}; // nama tanaman => { jenis => total }

      Object.keys(dataset).forEach(tanaman => {
        const entries = dataset[tanaman];

        entries.forEach(entry => {
          const label = entry.jenis_tanaman;

          if (!labels.includes(label)) labels.push(label);

          if (!seriesMap[tanaman]) seriesMap[tanaman] = {};
          seriesMap[tanaman][label] = (seriesMap[tanaman][label] || 0) + entry.ton_volume_produksi;
        });
      });

      const series = Object.keys(seriesMap).map(tanaman => ({
        name: tanaman,
        data: labels.map(label => seriesMap[tanaman][label] || 0)
      }));

      const chartId = `chart-gabungan`;

      const selectedPeriode = periode.val();
      const [year, month] = selectedPeriode.split('-');
      const monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
      ];
      const monthName = monthNames[parseInt(month) - 1];
      const chartTitle = `Produksi Tanaman Bulan ${monthName} ${year}`;

      $('#chart_container').append(`
        <div class="mb-5 w-full rounded-2xl bg-white shadow-md p-4 border">
          <h2 class="text-center text-lg font-semibold text-gray-700 mb-2">${chartTitle}</h2>
          <div id="${chartId}" class="shadow border rounded-md p-2 bg-white"></div>
        </div>
      `);

      const options = {   
        chart: {
          id: `${chartId}_main`,
          type: 'bar',
          height: 450,
          stacked: false,
          toolbar: {
            show: true,
            tools: {
              download: true,
              selection: true,
              zoom: true,
              zoomin: true,
              zoomout: true,
              pan: true,
              reset: true,
              customIcons: [
                {
                  icon: '<iconify-icon icon="teenyicons:pdf-solid"></iconify-icon>',
                  index: -1,
                  title: 'Download PDF',
                  class: 'custom-download-pdf',
                  click: function(chart, options, e) {
                    ApexCharts.exec(`${chartId}_main`, 'dataURI').then(({ imgURI }) => {
                      $.ajax({
                        url: '/export-pdf-chart',
                        type: 'POST',
                        data: {
                          _token: "{{ csrf_token() }}",
                          image: imgURI,
                          title: chartTitle,
                        },
                        xhrFields: {
                          responseType: 'blob'
                        },
                        success: function(blob) {
                          const url = window.URL.createObjectURL(blob);
                          const a = document.createElement('a');
                          a.href = url;
                          a.download = `${chartTitle.replace(/\s+/g, '_')}_${new Date().toISOString().split('T')[0]}.pdf`;
                          document.body.appendChild(a);
                          a.click();
                          a.remove();
                          window.URL.revokeObjectURL(url);
                        },
                        error: function (xhr) {
                          console.error('PDF Export Error:', xhr.responseText);
                          alert("Gagal mengunduh PDF. Silakan coba lagi.");
                        }
                      });
                    }).catch(function(error) {
                      console.error('Chart image generation error:', error);
                      alert("Gagal menggenerate gambar chart untuk PDF.");
                    });
                  }
                }
              ]
            }
          },
          animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
          },
          selection: {
            enabled: true,
            type: 'x',
            fill: {
              color: '#24292e',
              opacity: 0.1
            },
            stroke: {
              width: 1,
              dashArray: 3,
              color: '#24292e',
              opacity: 0.4
            }
          },
          zoom: {
            enabled: true,
            type: 'x',
            autoScaleYaxis: true
          }
        },
        series: series,
        xaxis: {
          categories: labels,
          title: { text: 'Jenis Tanaman' }
        },
        yaxis: {
          title: { text: 'Produksi (Ton)' },
          labels: {
            formatter: value => value.toLocaleString('id-ID') + ' Ton'
          }
        },
        tooltip: {
          y: {
            formatter: value => `${value} ton`
          }
        },
        legend: {
          position: 'top',
          onItemClick: {
            toggleDataSeries: true
          }
        },
        responsive: [{
          breakpoint: 768,
          options: {
            chart: {
              height: 300
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
      };

      const newChart = new ApexCharts(document.querySelector(`#${chartId}`), options);
      newChart.render();
    }

    function fetchDataAndRenderChart() {
      $.ajax({
        type: 'GET',
        url: `{{ route('api.dtphp.produksi') }}`,
        data: {
          _token: "{{ csrf_token() }}",
          periode: periode.val()
        },
        success: function (response) {
          console.log(response);
          
          $('#periode_placeholder').html(`- ${response.periode.toUpperCase()}`)
          renderChartFromData(response);
        },
        error: function (xhr) {
          $('#chart_container').html(`
            <div class="text-center p-4 border-2 border-dashed border-red-200 rounded-lg shadow-md bg-red-50">
              <h3 class="text-lg font-semibold text-red-500">Error</h3>
              <p class="text-red-400">Gagal memuat data. Silakan coba lagi.</p>
            </div>
          `);
          console.error("AJAX Error:", xhr.responseText);
        }
      });
    }

    $(document).ready(function () {
      fetchDataAndRenderChart();
    });

    $('#filterSubmitBtn').on('click', function () {
      fetchDataAndRenderChart();
    });
  
    // Search
    search.on("input", function () {
          const input_value = $(this).val().toLowerCase();
          let nama_tanaman = $(".nama_tanaman");
  
          nama_tanaman.each(function () {
              let item_text = $(this).text().toLowerCase();
  
              if (item_text.includes(input_value)) {
                  $(this).parent().removeClass("hidden");
              } else {
                  $(this).parent().addClass("hidden");
              }
          });
      });
</script>