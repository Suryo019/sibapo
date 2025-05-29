<x-pegawai-layout title="Visualisasi Data Dinas">
  
    <!-- Dropdown -->
    <div class="flex justify-end my-4">
        <div class="flex items-center justify-between w-full gap-6 max-md:flex-wrap max-md:gap-4">
          <!-- Search Component -->
          <x-search>
            Cari ikan...
          </x-search>

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
            <a href="{{ route('pegawai.perikanan.detail') }}" class="flex items-center text-lg font-semibold max-md:text-base w-full text-pink-650 gap-3">LIHAT DETAIL <i class="bi bi-arrow-right font-bold"></i></a>
          </div>
        </div>
  
        <!-- Chart Card -->
        <div class="w-full flex items-center justify-center flex-col" id="chart_container">
          {{-- <div id="chart_container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-4"> --}}
              {{-- Diisi pake ajax --}}
        </div>
  </main>
</x-pegawai-layout>

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

    Object.keys(dataset).forEach((ikan,index) => {
      const entries = dataset[ikan];
      const labels = entries.map(item => item.jenis_ikan);
      const produksi = entries.map(item => item.ton_produksi);

      const chartId = `chart-bulanan-${index}`;

      $('#chart_container').append(`
        <div class="mb-5 w-full rounded-2xl bg-white shadow-md p-4 border">
          <h2 class="nama_ikan text-center text-lg font-semibold text-gray-700 mb-2">Produksi Ikan ${ikan}</h2>
          <div id="${chartId}" class="shadow border rounded-md p-2 bg-white"></div>
        </div>
      `);

      const options = {
        chart: {
          type: 'bar',
          height: 350
        },
        series: [
          {
            name: 'Produksi (ton)',
            data: produksi.length ? produksi : [0]
          }
        ],
        xaxis: {
          title: { text: 'Ikan' },
          categories: labels,
          labels: { style: { fontSize: '12px' } }
        },
        yaxis: {
            title: { text: 'Produksi (Ton)' },
            labels: {
                formatter: function(value) {
                    return value.toLocaleString('id-ID') + 'Ton';
                }
            }
        },
        tooltip: {
          y: {
            formatter: value => `${value} ton`
          }
        }
    };

    const newChart = new ApexCharts(document.querySelector(`#${chartId}`), options);
    newChart.render();
    });
  }

  function fetchDataAndRenderChart() {
    $.ajax({
      type: 'GET',
      url: `{{ route('api.dp.index') }}`,
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
        let nama_ikan = $(".nama_ikan");

        nama_ikan.each(function () {
            let item_text = $(this).text().toLowerCase();

            if (item_text.includes(input_value)) {
                $(this).parent().removeClass("hidden");
            } else {
                $(this).parent().addClass("hidden");
            }
        });
    });
</script>