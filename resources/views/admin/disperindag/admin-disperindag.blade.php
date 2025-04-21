<x-admin-layout>

    <main class="flex-1 p-6 max-md:p-4">
        <h2 class="text-2xl font-semibold text-green-900 mb-4 max-md:text-xl max-md:text-center max-md:mb-10">{{ $title }}</h2>
    
        <!-- Dropdown -->
        <div class="flex flex-wrap justify-end items-start gap-4 my-4">
            <!-- Dropdown Filter -->
            <div class="flex flex-wrap gap-4 max-md:gap-2">
                {{-- Filter Pasar --}}
                <select class="border w-36 max-md:w-24 p-2 rounded bg-white select2 text-xs max-md:text-[10px]" id="pilih_pasar">
                    <option value="" disabled selected class="text-xs">Pilih Pasar</option>
                    @foreach ($markets as $market)
                        <option value="{{ $market }}">{{ $market }}</option>
                    @endforeach
                </select>
    
                {{-- Filter Periode --}}
                <select class="border w-36 max-md:w-24 p-2 rounded bg-white select2 text-xs max-md:text-[10px]" disabled id="pilih_periode">
                    <option value="" disabled selected class="text-xs">Pilih Periode</option>
                    @foreach ($periods as $period)
                        <option value="{{ $period }}">{{ $period }}</option>
                    @endforeach
                </select>
    
                {{-- Filter Bahan Pokok --}}
                <select class="border w-36 max-md:w-24 p-2 rounded bg-white select2 text-xs max-md:text-[10px]" disabled id="pilih_bahan_pokok">
                    <option value="" disabled selected class="text-xs">Pilih Bahan Pokok</option>
                    @foreach ($data as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    
        <!-- Chart Placeholder -->
        <div class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8 max-md:p-4" id="chart_container">
            <div class="w-full flex items-center justify-center flex-col mb-3 font-bold text-green-900 text-center max-md:text-[12px] max-md:mb-3">
                <h3>Data Harga Bahan Pokok <b id="bahan_pokok"></b> <span id="pasar"></span> <span id="periode"></span></h3>
            </div>
            
            <!-- Placeholder saat chart belum tersedia -->
            <div id="chart_placeholder" class="text-gray-500 text-center text-sm max-md:text-[10px]">
                Silakan pilih pasar, periode, dan bahan pokok untuk menampilkan data grafik.
            </div>
        
            <!-- Chart akan muncul di sini -->
            <div id="chart" class="w-full hidden"></div>
        </div>
    
        <!-- Button -->
        <div class="flex justify-center mt-6">
            <a href="{{ route('disperindag.detail') }}">
                <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800 text-sm max-md:text-xs max-md:px-4 max-md:py-1">
                    Lihat Detail Data
                </button>
            </a>
        </div>
    </main>
    

</x-admin-layout>

<script>
    var chart;
    var debounceTimer;

    $('#pilih_pasar').on('change', function() {
        $('#pilih_periode').prop('disabled', false).val('');
        $('#pilih_bahan_pokok').prop('disabled', true).val('');
    });

    $('#pilih_periode').on('change', function() {
        $('#pilih_bahan_pokok').prop('disabled', false);
    });

    $('#pilih_pasar, #pilih_periode, #pilih_bahan_pokok').on('change', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const pasar = $('#pilih_pasar').val();
            const periode = $('#pilih_periode').val();
            const bahanPokok = $('#pilih_bahan_pokok').val();

            if (!pasar || !periode || !bahanPokok) {
                return;
            }

            $.ajax({
                type: "GET",
                url: "{{ route('api.dpp.index') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    pasar: pasar,
                    periode: periode,
                    bahan_pokok: bahanPokok
                },
                success: function(response) {
                    $('#bahan_pokok').text(bahanPokok);
                    $('#pasar').text(pasar);
                    $('#periode').text(periode);

                    let dataset = response.data;
                    
                    if (!dataset || dataset.length === 0) {
                        if (chart) {
                            chart.destroy();
                            chart = null;
                        }
                        $('#chart').addClass('hidden');
                        $('#chart_placeholder').html(`
                            <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-500">Data Tidak Ditemukan</h3>
                                <p class="text-gray-400">Tidak ada data untuk kriteria yang dipilih.</p>
                            </div>
                        `).show();
                        return;
                    }

                    let labels = dataset.map(item => item.hari);
                    let data = dataset.map(item => item.kg_harga);

                    // Hanya render jika data berbeda
                    if (!chart || JSON.stringify(chart.w.config.series[0].data) !== JSON.stringify(data)) {
                        $('#chart_placeholder').empty().hide();
                        $('#chart').removeClass('hidden');

                        if (chart) {
                            chart.destroy();
                        }

                        chart = new ApexCharts(document.querySelector("#chart"), {
                            chart: {
                                type: 'line',
                                height: 350,
                                animations: {
                                    enabled: true,
                                    easing: 'easeinout',
                                    speed: 800
                                },
                                events: {
                                    resized: function(chartContext, config) {
                                        const width = chartContext.el.offsetWidth;

                                        if (width < 480) {
                                            chart.updateOptions({
                                                stroke: {
                                                    width: 1
                                                }
                                            });
                                        } else if (width < 768) {
                                            chart.updateOptions({
                                                stroke: {
                                                    width: 2
                                                }
                                            });
                                        } else {
                                            chart.updateOptions({
                                                stroke: {
                                                    width: 3
                                                }
                                            });
                                        }
                                    }
                                }
                            },
                            series: [{
                                name: 'Harga (Rp)',
                                data: data
                            }],
                            xaxis: {
                                categories: labels,
                                labels: {
                                    style: {
                                        fontSize: '12px'
                                    }
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Harga (Rp)'
                                },
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
                            },
                            responsive: [{
                                breakpoint: 768,
                                options: {
                                    chart: {
                                        height: 300
                                    },
                                }
                            }, 
                            {
                                breakpoint: 480,
                                options: {
                                    chart: {
                                        height: 250
                                    },
                                    xaxis: {
                                        labels: {
                                            style: {
                                                fontSize: '10px'
                                            }
                                        }
                                    },
                                    yaxis: {
                                        labels: {
                                            style: {
                                                fontSize: '10px'
                                            }
                                        }
                                    },
                                }
                            }],
                        });
                        
                        chart.render();
                    }
                },
                error: function(xhr) {
                    $('#chart_placeholder').html(`
                        <div class="text-center p-4 border-2 border-dashed border-red-200 rounded-lg shadow-md bg-red-50">
                            <h3 class="text-lg font-semibold text-red-500">Error</h3>
                            <p class="text-red-400">Gagal memuat data. Silakan coba lagi.</p>
                        </div>
                    `);
                    console.error("AJAX Error:", xhr.responseText);
                }
            });
        }, 300); // Debounce 300ms
    });

    // Reset semua saat halaman dimuat
    $(document).ready(function() {
        $('#pilih_periode').prop('disabled', true);
        $('#pilih_bahan_pokok').prop('disabled', true);
    });
</script>