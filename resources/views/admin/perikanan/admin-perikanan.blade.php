<x-admin-layout>
  
      <!-- Dropdown -->
      <div class="flex justify-end my-4">
          <div class="flex items-center justify-between w-full gap-6 max-md:flex-wrap max-md:gap-4">
            <!-- Search Component -->
            <x-search></x-search>

            {{-- Filter --}}
        <div class="flex justify-end">
          <div class="relative flex justify-end">
              <x-filter></x-filter>

              <!-- Modal Background -->
              <div id="filterModal" class="mt-10 absolute hidden items-center justify-center z-50">
                  <!-- Modal Content -->
                  <div class="bg-white w-96 max-md:w-80 rounded-lg shadow-black-custom p-6 relative">
                      <!-- Close Button -->
                      <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                          <i class="bi bi-x text-4xl"></i> 
                      </button>
                      
                      <h2 class="text-center text-pink-500 font-semibold text-lg mb-4">
                          Filter
                      </h2>

                      <form action="" method="get">
                          <div class="space-y-4">
                              <!-- Nama Pasar -->
                              <div class="flex flex-col">
                                <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                                  Pilih Periode
                              </label>
                              <select id="pilih_periode"
                                  class="w-full max-md:w-28 rounded border border-gray-300 p-2 bg-white text-sm max-md:text-xs focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                  <option value="" disabled selected>Pilih Periode</option>
                                  @foreach ($periods as $period)
                                      <option value="{{ $period }}">{{ $period }}</option>
                                  @endforeach
                              </select>
                              </div>

                              <!-- Periode -->
                              <div class="flex flex-col">
                                <label for="pilih_minggu" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">
                                  Minggu ke
                              </label>
                              <select id="pilih_minggu"
                                  class="w-full max-md:w-28 rounded border border-gray-300 p-2 bg-white text-sm max-md:text-xs focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                  disabled>
                                  <option value="" disabled selected>Pilih Minggu</option>
                                  <option value="1">Minggu 1</option>
                                  <option value="2">Minggu 2</option>
                                  <option value="3">Minggu 3</option>
                                  <option value="4">Minggu 4</option>
                              </select>
                              </div>
                          </div>

                          <div class="w-full flex justify-end gap-3 mt-10">
                              <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-1">Reset</button>
                        <button type="Submit" class="bg-pink-650 text-white rounded-lg w-20 p-1">Cari</button>
                          </div>
                      </form>
                  </div> 
              </div> 
          </div> 
        </div>

          </div>
        </div>
          
  
      <!-- Chart Container -->
      <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4">
          <a href="{{ route('perikanan.index') }}" class="text-decoration-none text-dark flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
              </svg>                      
          </a>
          <h3 class="text-lg font-semibold text-center max-md:text-base">Volume Produksi</h3>
      </div>

      <div class="w-full bg-white rounded-lg shadow-md flex items-center justify-center flex-col p-8 max-md:p-4 border bg-gray-10 border-gray-20">
          <div class="flex items-center flex-col mb-3 font-bold text-green-900 text-center max-md:text-[12px]">
              <h3>Neraca Ketersediaan dan Kebutuhan Bahan Pangan Pokok</h3>
              <h3><span id="minggu" class="font-bold"></span> <span id="periode" class="font-bold"></span></h3>
          </div>
  
          <!-- Placeholder -->
          <div id="chart_placeholder" class="w-full text-center  ">
              <p class="text-gray-500 text-sm max-md:text-xs">Silakan pilih periode dan minggu untuk menampilkan data</p>
          </div>
  
          <!-- Chart -->
          <div id="chart" class="w-full hidden"></div>
      </div>
  
      <!-- Button -->
      <div class="flex justify-start mt-6">
          <a href="{{ route('perikanan.detail') }}" class="inline-flex items-center px-6 py-2 bg-yellow-550 hover:bg-yellow-500 text-white text-sm max-md:text-xs max-md:px-4 max-md:py-1 rounded-xl shadow-sm transition-colors duration-200 ">
              Lihat Detail Data
          </a>
      </div>
    </main>
  
    @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const periodeSelect = document.getElementById('pilih_periode');
        const mingguSelect = document.getElementById('pilih_minggu');
        const chartContainer = document.getElementById('chart');
        const placeholder = document.getElementById('chart_placeholder');
        let chart = null;
        let debounceTimer;
  
        // Load ApexCharts dynamically
        function loadApexCharts() {
          return new Promise((resolve) => {
            if (window.ApexCharts) {
              resolve();
            } else {
              const script = document.createElement('script');
              script.src = "{{ asset('js/apexcharts.min.js') }}";
              script.onload = resolve;
              document.head.appendChild(script);
            }
          });
        }
  
        periodeSelect.addEventListener('change', function() {
          mingguSelect.disabled = !this.value;
        });
  
        function fetchChartData() {
          const periode = periodeSelect.value;
          const minggu = mingguSelect.value;
  
          if (!periode || !minggu) return;
  
          clearTimeout(debounceTimer);
          debounceTimer = setTimeout(async () => {
            try {
              const response = await fetch(`{{ route('api.dkpp.index') }}?periode=${periode}&minggu=${minggu}`, {
                headers: {
                  'Accept': 'application/json',
                  'X-Requested-With': 'XMLHttpRequest',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
              });
  
              if (!response.ok) throw new Error('Network response was not ok');
  
              const { data } = await response.json();
  
              if (!data || data.length === 0) {
                showNoDataMessage();
                return;
              }
  
              await loadApexCharts();
              renderChart(data, periode, minggu);
            } catch (error) {
              showErrorMessage();
              console.error('Fetch error:', error);
            }
          }, 300);
        }
  
        function renderChart(data, periode, minggu) {
          const ketersediaan = data.map(item => item.ton_ketersediaan);
          const kebutuhan = data.map(item => item.ton_kebutuhan_perminggu);
          const komoditas = data.map(item => item.jenis_komoditas);
  
          const options = {
            chart: {
              type: 'line',
              height: 350,
              animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
              },
              toolbar: {
                show: true,
                tools: {
                  download: true,
                  selection: true,
                  zoom: true,
                  zoomin: true,
                  zoomout: true,
                  pan: true,
                  reset: true
                }
              }
            },
            series: [
              {
                name: 'Ketersediaan (ton)',
                data: ketersediaan
              },
              {
                name: 'Kebutuhan (ton)',
                data: kebutuhan
              }
            ],
            xaxis: {
              categories: komoditas,
              labels: {
                style: {
                  fontSize: '12px'
                }
              }
            },
            yaxis: {
              title: {
                text: 'Ton'
              },
              labels: {
                formatter: function(value) {
                  return value.toLocaleString();
                }
              }
            },
            colors: ['#10B981', '#EF4444'], // Green for availability, red for needs
            stroke: {
              width: 3,
              curve: 'smooth'
            },
            markers: {
              size: 5
            },
            tooltip: {
              y: {
                formatter: function(value) {
                  return value.toLocaleString() + ' ton';
                }
              }
            },
            legend: {
              position: 'top'
            }
          };
  
          if (chart) {
            chart.updateOptions(options);
          } else {
            placeholder.classList.add('hidden');
            chartContainer.classList.remove('hidden');
            chart = new ApexCharts(chartContainer, options);
            chart.render();
          }
  
          document.getElementById('minggu').textContent = "Minggu ke-" + minggu;
          document.getElementById('periode').textContent = periode;
        }
  
        function showNoDataMessage() {
          placeholder.innerHTML = `
            <div class="text-center p-4">
              <p class="text-gray-500 text-sm max-md:text-xs">Tidak ada data untuk periode yang dipilih</p>
            </div>
          `;
          placeholder.classList.remove('hidden');
          chartContainer.classList.add('hidden');
          if (chart) {
            chart.destroy();
            chart = null;
          }
        }
  
        function showErrorMessage() {
          placeholder.innerHTML = `
            <div class="text-center p-4">
              <p class="text-red-500 text-sm max-md:text-xs">Gagal memuat data. Silakan coba lagi.</p>
            </div>
          `;
          placeholder.classList.remove('hidden');
          chartContainer.classList.add('hidden');
          if (chart) {
            chart.destroy();
            chart = null;
          }
        }
  
        periodeSelect.addEventListener('change', fetchChartData);
        mingguSelect.addEventListener('change', fetchChartData);
      });

    </script>
    @endpush

    <script>
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
  </x-admin-layout>