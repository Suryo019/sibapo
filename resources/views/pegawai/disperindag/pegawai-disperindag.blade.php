<x-pegawai-layout>

    <!-- Dropdown -->
    {{-- <x-filter></x-filter> --}}

    {{-- Abaikan DULU! --}}
    <div class="flex justify-between items-center gap-4 my-4 max-md:flex-wrap">
        <!-- Search Component -->
        <x-search></x-search>
    
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
                                @foreach ($markets as $market)
                                    <option value="{{ $market->nama_pasar }}" {{ old('pasar') == $market->nama_pasar ? 'selected' : '' }}>{{ $market->nama_pasar }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Periode -->
                        <div class="flex flex-col">
                            <label for="pilih_periode" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">Pilih Periode</label>
                            <select id="pilih_periode" class="border w-full max-md:w-full p-2 rounded bg-white select2 text-xs" disabled>
                                <option value="" disabled selected>Pilih Periode</option>
                                @foreach ($periods as $period)
                                    <option value="{{ $period }}">{{ $period }}</option>
                                @endforeach
                            </select>
                            {{-- <input type="month" value="{{ date('Y-m') }}" name="periode" id="periode" class="border w-full max-md:w-full p-2 rounded bg-white text-xs"> --}}
                        </div>

                        <!-- Bahan Pokok -->
                        <div class="flex flex-col">
                            <label for="pilih_bahan_pokok" class="block text-sm font-medium text-gray-700 mb-1 max-md:text-xs">Pilih Bahan Pokok</label>
                            <select id="pilih_bahan_pokok" class="border w-full max-md:w-full p-2 rounded bg-white select2 text-xs" disabled>
                                <option value="" disabled selected>Pilih Bahan Pokok</option>
                                @foreach ($data as $item)
                                    <option value="{{ $item->nama_bahan_pokok }}">{{ $item->nama_bahan_pokok }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="w-full flex justify-end gap-3 mt-10">
                        <button type="reset" class="bg-yellow-550 text-white rounded-lg w-20 p-1 max-md:w-1/2">Reset</button>
                        <button type="submit" class="bg-pink-650 text-white rounded-lg w-20 p-1 max-md:w-1/2">Cari</button>
                    </div>
                </form>
            </x-filter-modal>
        </div>
    </div>
    
    <main class="flex-1 p-6 max-md:p-4 bg-gray-10 border-gray-20 border-[3px] rounded-[20px]">
        <div class="w-full flex items-center gap-2 mb-4 max-md:flex-col max-md:items-start max-md:gap-1">
            <a href="javascript:history.back()" class="text-decoration-none text-dark flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-6 h-6 max-md:w-5 max-md:h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>                      
            </a>
            <h2 class="text-2xl font-semibold text-black max-md:text-xl max-md:text-center w-full">
                {{ $title }}
            </h2>
        </div>
    
        <!-- Chart Placeholder -->
        <div class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8 max-md:p-4 border bg-gray-10 border-gray-20" id="chart_container">
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
        <div class="flex justify-start mt-6">
            <a href="{{ route('pegawai.disperindag.detail') }}">
                <button class="bg-yellow-550 text-md text-white px-3 py-2 rounded-lg hover:bg-yellow-500 max-md:text-xs max-md:px-4 max-md:py-1">
                    Lihat Detail Data
                </button>
            </a>
        </div>
    </main>
    

    

</x-pegawai-layout>

<script>
    // Ini ntar hapus cuy
    const pasar = 'Pasar Tanjung';
    const periode = 'May 2025';
    const bahanPokok = 'Minyak Goreng';
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
    // Sampe sini

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

    // Reset semua saat halaman dimuat
    $(document).ready(function() {
        $('#pilih_periode').prop('disabled', true);
        $('#pilih_bahan_pokok').prop('disabled', true);
    });
</script>