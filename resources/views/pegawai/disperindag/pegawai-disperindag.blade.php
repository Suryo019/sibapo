<x-pegawai-layout title="Visualisasi Data Dinas">

    <!-- Dropdown -->
    {{-- <x-filter></x-filter> --}}

    {{-- Abaikan DULU! --}}
    <div class="flex justify-between items-center gap-4 my-4 max-md:flex-wrap">
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
                            <select name="pasar" id="pilih_pasar" class="border border-black p-2 rounded-full bg-white w-full select2 text-sm max-md:text-xs">
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
    let chart;
    let debounceTimer;
    
    let pasar = $('#pilih_pasar').val();
    let periode = $('#pilih_periode').val();
    const search = $('#search');

    // Fungsi untuk render grafik berdasarkan dataset
    function renderCharts(dataset) {
        const container = $('#chart_container');
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

        Object.keys(dataset).forEach((bahan, index) => {
            const entries = dataset[bahan];
            entries.sort((a, b) => a.hari - b.hari);

            const labels = entries.map(item => item.hari);
            const data = entries.map(item => item.kg_harga);
            const chartId = `chart_${index}`;

            container.append(`
                <div class="mb-5 w-full rounded-2xl bg-white shadow-md p-4 border">
                    <h4 class="text-center text-md font-bold mb-2 jenis_bahan_pokok_col">${bahan}</h4>
                    <div id="${chartId}" class="w-full"></div>
                </div>
            `);

            const chart = new ApexCharts(document.querySelector(`#${chartId}`), {
                chart: {
                    id: `${chartId}_${index}`,
                    type: 'line',
                    height: 350,
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
                                        ApexCharts.exec(`${chartId}_${index}`, 'dataURI').then(({ imgURI }) => {
                                            $.ajax({
                                                url: '/export-pdf-chart',
                                                type: 'POST',
                                                data: {
                                                    image: imgURI,
                                                    title: bahan,
                                                },
                                                xhrFields: {
                                                    responseType: 'blob'
                                                },
                                                success: function(blob) {
                                                    const url = window.URL.createObjectURL(blob);
                                                    const a = document.createElement('a');
                                                    a.href = url;
                                                    a.download = 'chart-export.pdf';
                                                    document.body.appendChild(a);
                                                    a.click();
                                                    a.remove();
                                                },
                                                error: function () {
                                                    alert("Gagal mengunduh PDF");
                                                }
                                            });
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
                    }
                },
                series: [{
                    name: 'Harga (Rp)',
                    data: data
                }],
                xaxis: {
                    title: { text: 'Hari' },
                    categories: labels,
                    labels: {
                        style: { fontSize: '12px' }
                    }
                },
                yaxis: {
                    title: { text: 'Harga (Rp)' },
                    labels: {
                        formatter: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            });

            chart.render();
        });
    }


    // Fungsi ambil data dan panggil renderCharts()
    function fetchChartData(pasar, periode) {
        $.ajax({
            type: "GET",
            url: "{{ route('api.dpp.index') }}",
            data: {
                _token: "{{ csrf_token() }}",
                pasar: pasar,
                periode: periode
            },
            success: function(response) {
                // console.log(response);
                $('#periode_placeholder').html(`- ${response.periode.toUpperCase()}`)
                $('#pasar_placeholder').html(pasar.toUpperCase());
                renderCharts(response.data);
            },
            error: function() {
                $('#chart_container').html(`
                    <div class="text-center p-4 border-2 border-dashed border-red-300 rounded-lg shadow-md bg-red-50">
                        <h3 class="text-lg font-semibold text-red-500">Gagal Memuat Data</h3>
                        <p class="text-red-400">Terjadi kesalahan saat mengambil data.</p>
                    </div>
                `);
            }
        });
    }

    // Inisialisasi data default
    fetchChartData(pasar, periode);

    // Event klik filter
    $('#filter_btn').on('click', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const selectedPasar = $('#pilih_pasar').val();
            const selectedPeriode = $('#pilih_periode').val();
            if (!selectedPasar || !selectedPeriode) return;

            pasar = selectedPasar;
            periode = selectedPeriode;
            fetchChartData(pasar, periode);
        }, 300);
    });

    // Toggle modal filter
    function toggleModal() {
        $('#filterModal').toggleClass('hidden flex');
    }

    $('#filterBtn').on('click', toggleModal);

    // Search
    search.on("input", function () {
        const input_value = $(this).val().toLowerCase();
        let jenis_bahan_pokok_col = $(".jenis_bahan_pokok_col");

        jenis_bahan_pokok_col.each(function () {
            let item_text = $(this).text().toLowerCase();

            if (item_text.includes(input_value)) {
                $(this).parent().removeClass("hidden");
            } else {
                $(this).parent().addClass("hidden");
            }
        });
    });
</script>
