{{-- @dd($data) --}}
<x-admin-layout>
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-semibold text-green-900">{{ $title }}</h2>
    
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <h3 class="text-lg font-semibold text-center">Data Bulan Januari 2025</h3>
            
            <!-- Search dan Dropdown -->
            <div class="flex justify-between my-4">
                <div class="flex items-center  border bg-white rounded-full w-64 flex-row h-9">
                    <span class="bi bi-search pl-5 pr-4"></span>
                    <input type="text" placeholder="Cari..." class="w-5/6 outline-none rounded-full">
                </div>
                <div class="flex gap-4">
                    <form action="" method="get">
                        <select class="border p-2 rounded bg-white select2" id="pilih_pasar">
                            {{-- <option value="" disabled selected>Pilih Pasar</option> --}}
                            <option value="" selected>Pasar Tanjung</option>
                            @foreach ($markets as $market)
                                <option value="{{ $market }}">{{ $market }}</option>
                            @endforeach
                        </select>
                        <select class="border p-2 rounded bg-white select2" disabled id="pilih_periode">
                            {{-- <option value="" disabled selected>Pilih Periode</option> --}}
                            <option value="" disabled selected>April 2025</option>
                            @foreach ($periods as $period)
                                <option value="{{ $period }}">{{ $period }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
    
            <!-- Tabel -->
            @if (isset($data))
                <div class="overflow-x-auto">
                    <table class="table-auto">
                        <thead>
                            <tr>
                                <th rowspan="2" class="border px-5 py-2">No</th>
                                <th rowspan="2" class="border px-5 py-2">Aksi</th>
                                <th rowspan="2" class="border px-5 py-2 whitespace-nowrap">Jenis Bahan Pokok</th>
                                <th colspan="30" class="border px-5 py-2">Harga Januari 2025</th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= $daysInMonth; $i++)
                                    <th class="border px-4 py-2">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr class="border">
                                    <td class="border p-2">{{ $loop->iteration }}</td>
                                    <td class="p-2 flex justify-center gap-2">
                                        <a href="{{ route('disperindag.edit', 1) }}">
                                            <button class="bg-yellow-400 text-center text-white rounded-md w-10 h-10">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </a>
                                        <button class="bg-red-500 text-center text-white rounded-md w-10 h-10">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                    <td class="border p-2">{{ $item['jenis_bahan_pokok'] }}</td>
                                    
                                    @for ($kolom = 1; $kolom <= $daysInMonth; $kolom++)
                                        <td class="border px-4 py-2 text-center whitespace-nowrap">
                                            @if (isset($item['harga_per_tanggal'][$kolom]))
                                                Rp. {{ number_format($item['harga_per_tanggal'][$kolom], 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
            <div class="flex items-center justify-center h-64">
                <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded-lg shadow-md bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-500">Data Not Found</h3>
                    <p class="text-gray-400">We couldn't find any data matching your request. Please try again later.</p>
                </div>
            </div>
            @endif
    
            <!-- Button Kembali & Tambah Data -->
            <div class="flex justify-between mt-4">
                <a href="/Public/Disperindag.html">
                <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Kembali</button>
                </a>
                <a href="Tambah.html">
                <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">Tambah Data</button>
                </a>
            </div>
        </div>
    </main>  
</x-admin-layout>

<script>
    $(document).ready(function() {
        $('.select2').select2();

        // Filter Value
        $('#pilih_pasar').on('change', function() {
            $('#pilih_periode').removeAttr('disabled');
        });

        $('#pilih_periode').on('change', function() {
            let pasar = $('#pilih_pasar').val();
            let periode = $('#pilih_periode').val();

            console.log(pasar);
            console.log(periode);
            
            
        })

    });
</script>