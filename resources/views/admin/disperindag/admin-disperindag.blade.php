<x-admin-layout>

    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <!-- Dropdown -->
        <div class="flex justify-between my-4">
            <div class="relative"> <!--tambahan ben opsi bisa dikanan-->
            </div>
            <div class="flex gap-4">
                {{-- Filter Pasar --}}
                <select class="border p-2 rounded bg-white select2" id="pilih_pasar">
                    <option value="" disabled selected>Pilih Pasar</option>
                    {{-- <option value="" selected>Pasar Tanjung</option> --}}
                    @foreach ($markets as $market)
                        <option value="{{ $market }}">{{ $market }}</option>
                    @endforeach
                </select>

                {{-- Filter Periode --}}
                <select class="border p-2 rounded bg-white select2" disabled id="pilih_periode">
                    <option value="" disabled selected>Pilih Periode</option>
                    {{-- <option value="" disabled selected>April 2025</option> --}}
                    @foreach ($periods as $period)
                        <option value="{{ $period }}">{{ $period }}</option>
                    @endforeach
                </select>

                {{-- Filter Bakpokting --}}
                <select class="border p-2 rounded bg-white select2" disabled id="pilih_bahan_pokok">
                    <option value="" disabled selected>Pilih Periode</option>
                    {{-- <option value="" disabled selected>Daging</option> --}}
                    @foreach ($data as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Chart Placeholder -->
        <div class="w-full bg-white rounded shadow-md flex items-center justify-center flex-col p-8" id="chart_container">
            <div class="flex items-center flex-col mb-3 font-bold text-green-910">
                <h3>Data Harga Bahan Pokok <b id="bahan_pokok"></b> <b id="pasar"></b> <b id="periode"></b></h3>
            </div>
            
            <!-- Placeholder saat chart belum tersedia -->
            <div id="chart_placeholder" class="text-gray-500 text-center">
                Silakan pilih pasar, periode, dan bahan pokok untuk menampilkan data grafik.
            </div>
        
            <!-- Chart akan muncul di sini -->
            <div id="chart" class="w-full hidden"></div>
        </div>
        
    
        <!-- Button -->
        <div class="flex justify-center mt-4">
            <a href="{{ route('disperindag.detail') }}">
                <button class="bg-green-700 text-white px-6 py-2 rounded-full hover:bg-green-800">
                    Lihat Detail Data
                </button>
            </a>
        </div>
    </main>

</x-admin-layout>

<script>
    var chart;

    $('#pilih_bahan_pokok').on('change', function() {
        $.ajax({
            type: "GET",
            url: "{{ route('api.dpp.index') }}",
            data: {
                _token: "{{ csrf_token() }}",
                pasar: $('#pilih_pasar').val(),
                periode: $('#pilih_periode').val(),
                bahan_pokok: $('#pilih_bahan_pokok').val()
            },
            success: function(response) {
                $('#bahan_pokok').html($('#pilih_bahan_pokok').val());
                $('#pasar').html($('#pilih_pasar').val());
                $('#periode').html($('#pilih_periode').val());

                let dataset = response.data;
                let jenis_bahan_pokok = [];
                let harga = [];

                $.each(dataset, function(key, value) {
                    jenis_bahan_pokok.push(value.jenis_bahan_pokok);
                    harga.push(value.kg_harga);
                });

                if (chart) {
                    chart.destroy();
                }

                $('#chart_placeholder').hide();
                $('#chart').removeClass('hidden');

                var options = {
                    chart: {
                        type: 'line',
                        height: 350
                    },
                    series: [{
                        name: 'Harga',
                        data: harga
                    }],
                    xaxis: {
                        categories: jenis_bahan_pokok
                    }
                };

                chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    $('#pilih_pasar').on('change', function() {
        $('#pilih_periode').removeAttr('disabled');
    });

    $('#pilih_periode').on('change', function() {
        $('#pilih_bahan_pokok').removeAttr('disabled');
        $('#chart_placeholder').show();
        $('#chart').addClass('hidden');
        if (chart) {
            chart.destroy();
        }
    });

</script>
